<?php


// 反射类绑定参数
invokeClass('view',[]);
public function invokeClass($className,$args = []) {
    $reflect = new ReflectionClass($className);
     // 获取所有常量
    $all_contants = $reflect->getConstants();
    if ($reflect->hasMethod('__make')) {
        // 
        $method = new ReflectionMethod($className,'__make');
    }


}

class View {
    public static function __make(Config $config)
    {
         return (new static())->init($config->pull('template'));
    } 
}







// 代理模式
Interface Behavior
{
    public function sendGift();
}
Class Girl 
{
    $name =  '';
    public function  __construct($name)
    {
        $this->name = $name;
    }
    public function getName() 
    {
        return $this->name;
    }
}
Class Boy implements Behavior
{
    $girl;
    public funcction __construct(Girl $girl) 
    {
        $this->girl = $girl;
    } 
    public function sendGift() 
    {
        echo 'buy gigt to' . $this->girl->getName();
    }
}

Class Proxy　implements Behavior
{
    public funcction __construct() 
    {

    }
}


class  mysql
{
    /*

数据类型优化
1. 整数
1.1 整数(存储空间)
tinyint(8),smallint(16),mediumint(24),int(32),bigint(64)
存储值的范围 -2(N次幂-1) ~ 2(N次幂-1)-1 
1.2 unsigned 去除负数范围，使正数的上线提高一倍，如tinyint (-127~128),unsigned tinyint(0~255)
有符号和无符号存储使用相同的存储空间，具有相同的性能。
1.3 为整数类型指定宽度
指定宽度对于应用来说没有任意，如常用 int(11)，这个和int(20) 或int(1) ，对于存储或计算来说这三者没有任何区别，
指定宽度也不会限制值的合法范围，只是限定客户端显示的个数。

2. 实数类型 （小数）
float 占用四个字节，double占用8个字节（更高的精度和范围，默认的浮点计算类型）
decimal 
不仅仅可以存小数，有可以存比bigint范围更大的整数 。
decimal（18,9）每四个字节存储九个数字， 小数点两边各存储九个数字，共8个字节，小数点又占一个字节，因此共九个字节；

更大的位数仅仅是一种格式（如财务数据精确到小数点后四位），在计算中会转化成double类型运算。
在数据量大时，可以指定bigint类型，将小数乘以相应的倍数。如 122.34 * 100 存储 12234，
避免浮点存数不精确和decimal精确但是计算代价高。

3.日期
datetime 存储范围 1001 年 ~ 9999 年，精度秒，与时区无关，8个字节存储空间
timestamp 1970-01-01 ~ 2038-12-23 ，4个字节存储。from_unixtime()将时间戳转化日期， 
unix_timestamp() 日期转为时间戳。 默认 not null。
因为timestamp根据时区转换，且存储空间小，无特殊要求（时间范围要求高），首选。
对于要求毫秒级的，可以使用bigint 或 double 代替。或使用mariadb



    */



}



class Person{
    private $age ;
    private $name ;
    public function __get($property) {
        if (isset($this->$property)) {
           return $this->$property;
        }else {
            return false;
        }
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }
}

$person = new Person ;
$person->name = 'lcl';
echo $person->name;
echo '<pre>';

die;

/*
mongodb
mongod.exe  --dbpath=D:/soft/mongo/db --logpath=D:/soft/mongo/log.txt --install

uninstall
1.stop services
2.mongod.exe  --dbpath=D:/soft/mongo/db --logpath=D:/soft/mongo/log.txt --remove

use:
show db name :
    db.getName()
create database : if the database exist to show ，else create
    use phptest
look at the base information
    db.stats()
*/
$array1 = array('blue'  => 1, 'green'  => 3,'red'  => 2);
$array2 = array( 'blue' => 6,'green' => 5, 'yellow' => 2);
print_r( array_intersect($array1,$array2));
print_r(array_intersect_key($array1,$array2));


$ret = array_map(function ($m,$n) {

    if ($m > 4) {
        var_dump($m);
        return $m * $n;
    }else {
        return $m;
    }

},range(1,8,2),range(2,8,2));
var_dump($ret);
$item = ['aa'=>'tt'];
settype($item,'array');
var_dump($item);
//unset($ret[1],$ret[3]);
array_splice($ret,-1,2,[44,55,66]);
var_dump($ret);
$array = range(1,6,1);
array_pop($array); //last remove
var_dump($array);
array_unshift($array,0);//first add
var_dump($array);
array_shift($array); //first remove
var_dump($array);
array_push($array,7); // last add
var_dump($array);
echo '<hr/>';

$array = range(1,6,1);

if (count($array) < 5) {
    $array  = array_pad($array,8,''); // not & array
} else {
   array_splice($array,5);
}
var_dump($array);

$arr1 = range(1,4,1);
$arr2 = range(1,6,1);
$arr_merge = array_merge($arr1,$arr2);
var_dump($arr_merge);
date_default_timezone_set('PRC');
echo date("Y-m-d H:i:s");
?>