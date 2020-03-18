<?php

namespace app\controller\test;



use app\lclsdk\validate\v3\ValidateException;
use app\lclsdk\validate\v3\ValidateRule;
use app\lclsdk\validate\v3\ValidateTool;

class ValidateTestV3 extends TestBase
{
    public function test()
    {
//        $ret = $this->method1();
//        $ret = $this->method2();
//        $ret = $this->method3();
//        $ret = $this->method4();
        $ret = $this->method5();
        dd($ret);
    }


    /**
     * 使用验证基类方法，不定义验证场景
     * @return array|bool
     */
    public function method1()
    {
        $reqParam = request()->param();
        $validate = new ValidateTool();
        $validate = $validate->rule('age','require|between:1,100')
            ->rule('username','require')
            ->batch(true);
        $ret = $validate->check($reqParam);
        if (!$ret) {
            $errors = $validate->getError();
            // 批量验证返回等是数组，视业务处理
            return is_array($errors) ? implode(',', $errors) : $errors;
        }

        return true;
    }
    /**
     * 使用验证基类方法，不定义验证场景，验证失败抛出异常
     * @return bool|string
     */
    public function method2()
    {
        $reqParam = request()->param();
        // 通过异常捕获错误信息,方便在 ExceptionHandle 统一处理
        try {
            $validate = new ValidateTool();
            $validate = $validate->rule('age','require|between:1,100')
                ->failException(true)
                ->check($reqParam);
        } catch (ValidateException $e) {
            $message = $e->getMessage();
            return $message;
        }
        return true;
    }

    /**
     * 使用验证基类方法，不定义验证场景，验证失败抛出异常
     * 自定义提示信息
     * @return bool|string
     */
    public function method3()
    {
        $reqParam = request()->param();
        // 通过异常捕获错误信息,方便在 ExceptionHandle 统一处理
        try {
            $validate = new ValidateTool();
            $validate->rule('age','require|between:1,100')
                ->rule([
                    'username' =>'require',
                    'email' =>'require',
                ])
                ->message([
                    'age.require' => '年龄必传',
                    'age.between' => '年龄在1-100',
                ])
                ->failException(true)
                ->batch(true)
                ->check($reqParam);
        } catch (ValidateException $e) {
            $message = $e->getMessage();
            return $message;
        }
        return true;
    }



    /**
     * 使用验证基类方法，不定义验证场景，验证失败抛出异常
     * 闭包使用
     * @return bool|string
     */
    public function method4()
    {
        $reqParam = request()->param();
        // 通过异常捕获错误信息,方便在 ExceptionHandle 统一处理
        try {
            $validate = new ValidateTool();
            $validate->rule('age','require|between:1,100')
                ->rule([
                    'username' => function($value, $data) {
                        if (empty($value)) {
                            return '用户名必传';
                        }
                        $len = mb_strlen($value, 'utf8');
                        if ($len > 4 || $len < 2) {
                            return "用户名长度在2-4个字符之间";
                        }
                        return true;
                    },
                ])
                ->message([
                    'age.require' => '年龄必传',
                    'age.between' => '年龄在1-100',
                ])
                ->failException(true)
                ->batch(true)
                ->check($reqParam);
        } catch (ValidateException $e) {
            $message = $e->getMessage();
            return $message;
        }
        return true;
    }


    /**
     * 使用验证基类方法，不定义验证场景，验证失败抛出异常
     * 验证规则使用
     * @return bool|string
     */
    public function method5()
    {
        $reqParam = request()->param();
        // 通过异常捕获错误信息,方便在 ExceptionHandle 统一处理
        try {
            $validate = new ValidateTool();
            $validate->rule('age',ValidateRule::isRequire())
                ->failException(true)
                ->batch(true)
                ->check($reqParam);
        } catch (ValidateException $e) {
            $message = $e->getMessage();
            return $message;
        }
        return true;
    }


}
