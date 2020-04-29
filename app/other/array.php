<?php

# 数组-并集，交集，差集,去重

# 并集
//键为整数，直接合并;键为字符串，相同的的键，后面的值会将前面的覆盖
array_merge([1,2],[2,3]); // [0=>1, 1=>2, 2=>2,3=>3]
array_merge(['1a'=>1,2=>2,3=>3],['1a'=>2,2=>3,'3'=>4]);
// ['1a'=>2, 0 => 2, 1=>3, 2=>3, 3=>4]

//通常计算两个数组的并集,先合并后去重
$union = array_unique(array_merge([1,2,3],[3,4,5]));

//创建一个数组，用一个数组的值作为其键名，另一个数组的值作为其值,两个数组个数必须相等
$array1 = array('blue'  => 1, 'red'  => 2, 'green'  => 3);
$array2 = array('green' => 5, 'blue' => 6, 'yellow' => 3);
$arr_combine = array_combine($array1,$array2);
// [ [1] => 5, [2] => 6, [3] => 3 ]


# 交集

$array1 = array('blue'  => 1, 'green'  => 3,'red'  => 2);
$array2 = array( 'blue' => 6,'green' => 5, 'yellow' => 2);
//对值去交集
$arr_intersect = array_intersect($array1,$array2);// [ [red] => 2 ]
//对键取交集
$arr_intersect_key = array_intersect_key($array1,$array2);
// [   [blue] => 1 ,[green] => 3 ]


# 差集

$arr1 = ['0'=>'white','b'=>'red','c'=>'0'];
$arr2 = [0=>'white','b'=>'grey','d'=>0];
//值的差集，非严格模式 '0'和0 相等
$arr_differ = array_diff($arr1,$arr2); //['b'=>'red']
//键的差集，非严格模式
$arr_differ_key = array_diff_key($arr1,$arr2); //['c'=>'0']
//键值的差集，非严格模式
$arr_differ_assoc = array_diff_assoc($arr1,$arr2);//[ "b"=>"red" , "c"=> "0"]
//用用户提供的回调函数做索引检查来计算数组的差集
$arr_diff_uassoc = array_diff_uassoc($arr1,$arr2,function ($a,$b){
    if($a==$b) return 0;
    return $a > $b ? 1 : -1;
});//[ "b"=>"red" , "c"=> "0"]

//用回调函数对键名比较计算数组的差集，键须是字符串，否则返回空
$array1 = array('blue'  => 1, 'red'  => 2, 'green'  => 3, 'purple' => 4);
$array2 = array('green' => 5, 'blue' => 6, 'yellow' => 7, 'cyan'   => 8);
$arr_diff_ukey = array_diff_ukey($array1, $array2, 'key_compare_func');
function key_compare_func($key1, $key2){
    if ($key1 == $key2) return 0;
    return $key1 > $key2 ? 1 : -1;
}
//["red"=> 2, "purple"=> 4]


# 对称差集
$difference = array_merge(array_diff($array1,$array2),array_diff($array2,$array1));


# 数组去重
$arr = ['red'=>'rose','white'=>'glory','black'=>'dark','grey'=>'dark'];
# 1.针对已处理完成的数组
$unique = array_unique($arr);
# 2.处理结果的同时创建新数组
$new_arr = [];
foreach ($arr as $k=>$v) {
    if( !in_array($v,$new_arr)) {
        $new_arr[] = $v;
    }
}
# 3. 使用关联数组，减少in_array() 线性检查，效率最快
$new_arr = [];
foreach ($arr as $k=>$v) {
    $new_arr[$v] = $v;
}
$ret = array_values($new_arr);
//或者 array_keys($new_arr) 稍慢



 // array_push ( array &$array , mixed $value1 [, mixed $... ] ) : int
//函数向第一个参数的数组尾部添加一个或多个元素（入栈），然后返回新数组的长度。
//该函数等于多次调用 $array[] = $value。
//注释：即使数组中有字符串键名，您添加的元素也始终是数字键。
//注释：如果用 array_push() 来给数组增加一个单元，还不如用 $array[] =，因为这样没有调用函数的额外负担

