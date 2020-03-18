<?php

namespace app\lclsdk\validate\v2;

use Throwable;

class ValidateException extends \RuntimeException {
    protected $error;

    public function __construct($error = "", $code = 0, Throwable $previous = null)
    {
        $this->error = $error;
        $this->message = is_array($error) ? implode(',', $error) : $error;  // 数组为批量验证
    }


    public function getError() {
        return $this->error;
    }
}