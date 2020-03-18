<?php

namespace app\controller\test;



use app\lclsdk\myTestValidate\v2\UserValidateTest;
use app\lclsdk\validate\v2\ValidateException;
use app\lclsdk\validate\v2\ValidateHelp;

class ValidateTestV2 extends TestBase
{
    public function test()
    {
//        $ret = $this->method1();
//        $ret = $this->method2();
//        $ret = $this->method3();
//        $ret = $this->method4();
        $ret = $this->method6();
        dd($ret);
    }


    /**
     * 验证失败抛出异常
     * @return bool|string
     */
    public function method1()
    {
        /*
         *兼容两种格式
         $rule = [
            'age'   => ['number', 'between' => '1,120'],
            'age'   => 'number|between|1,120',
        ];
        */

        $reqParam = request()->param();
        // 通过异常捕获错误信息
        try {
            ValidateHelp::myValidateOnlyScene(UserValidateTest::class)->scene('register')->check($reqParam);
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
        $object = ValidateHelp::myValidateOnlyScene(UserValidateTest::class)
                                ->scene('register')
                                ->failException(false);
        $result = $object->check($reqParam);
        if (true !== $result) {
            return $object->getError();
        }
        return true;
    }

    /**
     * 批量验证
     * @return array|bool
     */
    public function method3()
    {
        $reqParam = request()->param();
        // 通过异常捕获错误信息
        try {
            ValidateHelp::myValidateOnlyScene(UserValidateTest::class)
                            ->scene('register')
                            ->batch(true)
                            ->check($reqParam);
        } catch (ValidateException $e) {
            $message = $e->getMessage();
            return $message;
        }
        return true;
    }

    /**
     * 追加验证规则
     * @return array|bool
     */
    public function method4()
    {
        $reqParam = request()->param();
        // 通过异常捕获错误信息
        try {
            ValidateHelp::myValidateOnlyScene(UserValidateTest::class)
                ->scene('register')
                ->batch(true)
                ->append('password' ,'require|max:6')
                ->check($reqParam);
        } catch (ValidateException $e) {
            $message = $e->getMessage();
            return $message;
        }
        return true;
    }


    /**
     * 移除验证规则
     * @return array|bool
     */
    public function method5()
    {
        $reqParam = request()->param();
        // 通过异常捕获错误信息
        try {
            ValidateHelp::myValidateOnlyScene(UserValidateTest::class)
                ->scene('register')
                ->batch(true)
                ->remove('age' ,'between')
                ->check($reqParam);

            // remove('age', true) 第二个参数为true 代码移除该字段所有规则
        } catch (ValidateException $e) {
            $message = $e->getMessage();
            return $message;
        }
        return true;
    }

    /**
     * 自定义方法场景
     * @return array|bool
     */
    public function method6()
    {
        $reqParam = request()->param();
        // 方法场景 方法名 = scene + 场景名   sceneMyFlexible
        try {
            ValidateHelp::myValidateOnlyScene(UserValidateTest::class)
                ->scene('MyFlexible')
                ->check($reqParam);
        } catch (ValidateException $e) {
            $message = $e->getMessage();
            return $message;
        }
        return true;
    }



}
