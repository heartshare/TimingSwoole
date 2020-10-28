<?php 
/**
 * php单例模式 创建数据
 */
class TimeData
{
    private function __construct(){}
    private function __clone(){}
    private static $instance;
    private $timeData;
    public static function getInstance()
    {
        if(!self::$instance instanceof self){
            $instance = new self();
        }
        return $instance;
    }
/**
 *
 * @param Int $index 数据的索引
 * @param Array $data 存入的数据
 * 
 */
    public function setData($index, $data)
    {
         $this->timeData[$index] = $data;
    }
/**
 *
 * @param Int $index 数据的索引
 * @param string $key 数据的key
 * @param string $data 存入的数据
 * 
 */
    public function setIndexData($index, $key, $data = '')
    {
         $this->timeData[$index][$key] = $data;
    }
/**
 *
 * @param Int $index 数据的索引
 * @param string $key 数据的key
 * 
 */
    public function getIndexData($index, $key)
    {
         return $this->timeData[$index][$key];
    }
/**
 *
 * @param Int $index 数据的索引
 * 
 */
    public function delData($index)
    {
        unset( $this->timeData[$index] );
    }
/**
 *
 * @param Int $index 数据的索引
 * 
 */
    public function getData($index)
    {
        return $this->timeData[$index];
    }

    public function getAllData()
    {
        return $this->timeData;
    }

/**
 *
 * @param Int $page 当前页面
 * @param Int $number 页面显示多少条数据
 * 
 */
    public function getPageData($page = '1', $number = "1")
    {
        $total = count( $this->timeData );
        if($total > 0){
            $startnumber = $number;
            $reduce = $total - (($page - 1) * $number);
            if($reduce >= 0){
                if($reduce < $number){
                    $number = abs($reduce);
                }
            }
            else{
                $number = 0;
            }
            $arr = array_slice($this->timeData, - ($page * $startnumber), $number, true);
        }
        $arr['total'] = $total;
        return array_reverse($arr);
    }
}
?>
