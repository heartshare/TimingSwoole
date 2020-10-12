<?php 
    include './xyzsendpost.php';
    include './xyzData.php';
    //服务器生成
    $server = new Swoole\Websocket\Server("0.0.0.0", 7017);

    //服务器队列id及数据
    $arrid=2;
    //获取数据
    $timeDatas = timeData::getInstance();
    //////
    $server->on('open', function($server, $req) {
        echo "connection open: {$req->fd}\n";
    });

    $server->on('message', function($server, $frame) use(&$arrid,&$timeDatas)
    {
        $getdata = json_decode($frame->data,true);
        // var_dump($getdata );
        //获取当前执行命令列表
        if(isset($getdata['getarrdata']))
        {
            if(( $getdata['getarrdata'] == 1))
            {
                if($timeDatas->getAllData())
                {
                    $rearrdata = array_reverse($timeDatas->getAllData());
                    $server->push($frame->fd, json_encode( $rearrdata ));
                }
                return ;
            }

            else if( $getdata['getarrdata'] == 2 && !empty( $getdata['search'] ) )
            {

                if($timeDatas->getPageData( $getdata['search']['page'],$getdata['search']['limit'] ))
                {
                    $rearrdata = $timeDatas->getPageData($getdata['search']['page'],$getdata['search']['limit'] );
                    $server->push($frame->fd, json_encode( $rearrdata ));
                }
                return ;
            }
        }

        //-------获取当前执行命令列表
        //删除执行
        if(!empty($getdata['delete'])){
            $timeDatas->delData( $getdata['delete'] );
            return ;
        }
        //------删除执行
        //停止执行
        if(!empty($getdata['stop'])){
            
            $timeDatas->setIndexData($getdata['stop'],'ing',false);
            return ;
        }
        //-------停止执行

        ///生成数组数据 
        $a = empty($getdata['numss'])?0:$getdata['numss'];
     
        //新数据存储
        $timeDatas->setData($arrid,$getdata );
        $timeDatas->setIndexData($arrid,'keys',$arrid );
        $timeDatas->setIndexData($arrid,'times',empty($getdata['times'])?'0':$getdata['times'] );
        $timeDatas->setIndexData($arrid,'ing',true );
        $timeDatas->setIndexData($arrid,'starttime',empty($getdata['datestart'])?date("Y-m-d H:i:s",time()):date('Y-m-d H:i:s',strtotime($getdata['datestart'])) );
        $timeDatas->setIndexData($arrid,'numss',$a );

        ///------生成数组数据

        ////////执行方法
        flxedAfterCirculation($arrid++,$a,$timeDatas);

        //推送到Websocket
        //-----推送到Websocket

    });

////////////////////////简易http服务器
    $server->set([
       'enable_static_handler' => true,
       // 在这里设置静态资源的默认文件路径
       'document_root' => './dist/'
    ]);
    $server->on('request', function ($request, $response) {
        $data = $request->get;
        $response->header("Content-Type", "text/html; charset=utf-8");
        // 设置cookie
        $response->cookie('have', 'ok666');
        // 输出自定义内容
        $response->end('hello woeld, my name is zyx'.json_encode($data));
    });


    $server->on('close', function($server, $fd) {
        echo "connection close: {$fd}\n";
    });
//////////////////---------简易http服务器

    $server->start();


//定时执行命令
    function flxedAfterCirculation($id,&$a,&$timeDatas)
        {
        writeloginfo("log.txt",json_encode( $timeDatas->getData($id) ));

        if( $timeDatas->getIndexData($id,'times')<=0 ){
            echo "执行时间不能为0";
            $timeDatas->setIndexData($id,'ing',false);
            return ;
        }

        if( empty( $timeDatas->getIndexData($id,'datestart') ) )
        {
            $tim = $timeDatas->getIndexData($id,'times');
        }
        else
        {
            $tim = (strtotime( $timeDatas->getIndexData($id,'datestart') )-time())*1000+$timeDatas->getIndexData($id,'times'); 
            // echo $tim."\n";
            $timeDatas->setIndexData($id,'datestart','');
        }
        
        if($tim<=0)
        {
            // echo "时间已经过期,从当前时间执行";
            echo "时间已经过期,执行失败";
            $tim = $timeDatas->getIndexData($id,'times');
            $timeDatas->setIndexData($id,'datestart','');
            $timeDatas->setIndexData($id,'ing',false);
            writeloginfo("log.txt",json_encode('执行失败，时间已经过期'));
            // return ;
        }
        else
        {
            writeloginfo("log.txt",json_encode('执行成功'));
        }

        // echo time()."\n";
        ////////写入日志
        //----写入日志
        //////重复执行命令
         Swoole\Timer::after($tim, function() use ($id,&$a,&$timeDatas) {
            if(!empty( $timeDatas->getData($id) )  && $timeDatas->getIndexData($id,'ing') ){

                if( $timeDatas->getIndexData($id,'postTypes') == 2)
                {
                    go(function () use($timeDatas,$id)
                    {
                        echo "\n";
                        $return['back'] =  co::exec($timeDatas->getIndexData($id,'shellData'))    ;

                        writeloginfo("./log/".date("YmdHis",strtotime($timeDatas->getIndexData($id,'starttime'))).$timeDatas->getIndexData($id,'keys')."log.txt",json_encode($return));
                    });
                }
                else if( $timeDatas->getIndexData($id,'postTypes') == 1)
                {

                    $c = json_decode($timeDatas->getIndexData($id,'postData'),true);
                    $return['back'] =  send_post($timeDatas->getIndexData($id,'urls'), $c) . PHP_EOL;;

                    writeloginfo("./log/".date("YmdHis",strtotime($timeDatas->getIndexData($id,'starttime')) ).$timeDatas->getIndexData($id,'keys')."log.txt",json_encode($return));

                }
                
                //循环执行方法
                if( --$a  )
                {
                    flxedAfterCirculation($id,$a,$timeDatas);
                }
                else
                {
                    $timeDatas->setIndexData($id,'ing',false);
                }    

                 }
                //------循环执行方法
            });
        ////-----重复执行命令
}

/////////日志生成
function writeloginfo($file = 'log.txt',$content){

    if (!file_exists("log")){
        mkdir ("log",0777,true);
    }
    if($f  = file_put_contents($file, date("Y-m-d H:i:s",time()).".".$content."\n",FILE_APPEND)){
        // 这个函数支持版本(PHP 5) 
    }
}
//-----日志生成


 ?>