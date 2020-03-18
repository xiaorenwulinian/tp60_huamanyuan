<?php

namespace app\lclsdk\myTestValidate\v2;



use app\lclsdk\validate\v2\ValidateTool;

class UserValidateTest extends ValidateTool
{
    protected $rule = [
        'username'   => 'require',
        'age'        => 'require|between:1,100',
    ];

    protected $message = [
        'username.require' => '用户名必传',
    ];

    protected $scene = [
        'login'  =>  ['username'],
        'register'  =>  ['username','age','password'],
    ];

    /**
     * 自定义方法验证场景
     */
    public function sceneMyFlexible()
    {
        return $this->only(['age']);

    }
}

