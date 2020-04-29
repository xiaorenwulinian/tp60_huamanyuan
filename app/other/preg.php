<?php


echo '<pre>';
$str = 'abcd\\\\123/aBcd';
echo $str . '<br/>';
//针对域名\
$str1 = preg_replace('/[\\\]/','/',$str);
var_dump($str1);
$str2 = preg_match_all('/cd/i',$str1,$matches);
var_dump($str2);
var_dump($matches);

var_dump(str_replace('\\','/','abc\\\anc'));
var_dump(preg_match('/[^a-z]/','abbc1'));
/*

1.  (.) 任意字符
2.  (*) 0或多个
3.  (+) 至少1个
4.  (？) 0或1个

/^[\d]+?/
匹配数字
/[^123]/
任意字符不包括1，2，3

composer create-project --prefer-dist laravel/lumen=5.6.* lumen56
*/
// https://sogu-develop-testing.oss-cn-shanghai.aliyuncs.com/frontend/cert_file/KwkycanYNLS2QjH5YI2E5F8xmjlX8EvXdzQsxvI7.jpeg

// composer require jenssegers/mongodb=3.4.*
