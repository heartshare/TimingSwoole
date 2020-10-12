<?php 
/**
 * php单例模式 创建数据
 */
class timeData{
	private function __construct(){}
	private function __clone(){}
	private static $instance;
	private $timeData;
	public static function getInstance(){
		if(!self::$instance instanceof self){
			$instance = new self();
		}
		return $instance;
	}

	public function setData($index,$data){
		 $this->timeData[$index] = $data;
	}

	public function setIndexData($index,$key,$data=''){
		 $this->timeData[$index][$key] = $data;

	}

	public function getIndexData($index,$key){
		 return $this->timeData[$index][$key];

	}

	public function delData($index){
		unset( $this->timeData[$index] );
	}

	public function getData($index){
		return $this->timeData[$index];
	}

	public function getAllData(){
		return $this->timeData;
	}

	public function getPageData($page = '1',$number = "1"){
		$total = count( $this->timeData );
		if( $total>0)
		{
			$startnumber = $number;
			$reduce = $total - (($page-1)*$number);
			if( $reduce>=0 )
			{
				if($reduce<$number)
				{
					$number = abs($reduce);
				}
			}
			else
			{
				$number = 0;
			}
			$arr = array_slice($this->timeData,-($page*$startnumber),$number,true);
		}
		$arr['total'] = $total;
		return array_reverse( $arr );
	}
}

 ?>