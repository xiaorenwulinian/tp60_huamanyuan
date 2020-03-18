<?php

namespace app\lclsdk\validate\v3;

/**
 * Class ValidateRule
 * @package app\lclsdk\validate\v3
 * @method ValidateRule isRequire($rull, string $msg = '') static 验证字段不能为空
 */
class ValidateRule {

    // 验证字段的名称
    protected $title;

    // 当前验证规则
    protected $rule = [];

    // 验证提示信息
    protected $message = [];

    public function addItem(string $name, $rule = null, $msg = '')
    {
        if ($rule || $rule === 0) {
            // between:1,100
            $this->rule[$name] = $rule;
        } else  {
            // require
            $this->rule[] = $name;
        }
        $this->message[] = $msg;
        return $this;
    }

    public function getRule() : array
    {
        return $this->rule;
    }

    public function getMsg() : array
    {
        return $this->message;
    }

    public function getTitle() :string
    {
        return $this->title ?? '';
    }

    public function title($title)
    {
        $this->title = $title;
        return $this;
    }

    public function __call($method, $arguments)
    {
        // TODO: Implement __call() method.
        if ('is' == strtolower(substr($method,0,2))) {
            $method = substr($method, 2);
        }
        array_unshift($arguments, lcfirst($method));
        return call_user_func_array([$this, 'addItem'], $arguments);
    }

    public static function __callStatic($method, $arguments)
    {
        // TODO: Implement __callStatic() method.
        $validateRule = new static();
        if ('is' == strtolower(substr($method,0,2))) {
            $method = substr($method, 2);
        }
        array_unshift($arguments, lcfirst($method));
        return call_user_func_array([$validateRule, 'addItem'], $arguments);
    }
}