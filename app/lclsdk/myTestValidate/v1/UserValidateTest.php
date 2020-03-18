<?php

namespace app\lclsdk\myTestValidate\v1;



use app\lclsdk\validate\v1\ValidateTool;

class UserValidateTest extends ValidateTool
{
    protected $rule = [
        'username'   => 'require',
        'age'        => 'require|between:1,100'
    ];

    protected $message = [
        'username.require' => '用户名必传',
    ];

    protected $scene = [
        'login'  =>  ['username'],
        'register'  =>  ['username','age'],
    ];

}

