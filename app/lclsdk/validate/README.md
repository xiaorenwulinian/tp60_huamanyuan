MyValidate thinkphp6
===============

> 运行环境要求PHP7.1+。

## V1版本
使用 场景场景验证器，简化thinkphp验证功能，保留基本验证规则和使用方式
如验证失败是抛出异常还是返回错误信息，
自定义异常信息
自定义验证方法
使用方式
MyValidateHelp::myValidateOnlyScene(\app\lclsdk\myTestValidate\v1\UserValidateTest::class)->scene('register')->check($reqParam);


## V2版本

添加功能
batch()  批量验证规则， 
append() 追加验证
remove() 移除某些验证规则
自场景方法，更加灵活的追加和移除规则, scene . 自定义场景名
使用方式
ValidateHelp::myValidateOnlyScene(UserValidateTest::class)->scene('register')->check($reqParam);


## V3版本
闭包功能
验证规则



