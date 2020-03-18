<?php

namespace app\controller\test;



use app\lclsdk\validate\v1\ValidateException;
use app\lclsdk\validate\v1\ValidateHelp;

class ValidateTestV1 extends TestBase
{
    public function test() {
        return $this->method1();
        return $this->method2();
    }

    /**
     *  验证失败抛出异常
     * @return bool|string
     */
    public function method1()
    {
        $reqParam = request()->param();
        // 通过异常捕获错误信息
        try {
            ValidateHelp::myValidateOnlyScene(\app\lclsdk\myTestValidate\v1\UserValidateTest::class)->scene('register')->check($reqParam);
        } catch (ValidateException $e) {
            $message = $e->getMessage();
            return $message;
        }
        return true;
    }

    /**
     * 验证失败返回错误信息
     * @return array|bool
     */
    public function method2()
    {
        $reqParam = request()->param();
        // 通过返回结果进行判断
        $object = ValidateHelp::myValidateOnlyScene(\app\lclsdk\myTestValidate\v1\UserValidateTest::class)->scene('register')->failException(false);
        $result = $object->check($reqParam);
        if (true !== $result) {
            return $object->getError();
        }
        return true;
    }

}
