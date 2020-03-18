<?php

namespace app\lclsdk\validate\v2;


use app\lclsdk\validate\v2\ValidateTool;

class ValidateHelp
{
    /**
     * 生成验证对象,仅仅验证场景，格式        myValidateOnlyScene(\app\common\myTestValidate\v1\UserValidateTest::class)->scene('add')->check($reqParam);
     * @param string|array $validate      验证器类名
     * @return MyValidateTool
     */
    public static function myValidateOnlyScene($validate = '') : ValidateTool
    {

        if ('' === $validate) {
            //  未传入自定义验证器类，使用验证器基类
            $v = new ValidateTool();
        } else {
            if (false !== strpos($validate, '\\')) {
                // 包含命名空间
                $class = $validate;
            } else {
                // 补全命名空间， validate 命名空间需提前定义好
                $class = app()->parseClass('validate', $validate);
            }
            $v = new $class;
        }

        return $v->failException(true);
    }


}
