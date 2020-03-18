<?php

namespace app\lclsdk\validate\v1;

use Throwable;

class ValidateException extends \RuntimeException {
    protected $error;

    public function __construct($error = "", $code = 0, Throwable $previous = null)
    {
        $this->error = $error;
        $this->message = $error;
    }


    public function getError() {
        return $this->error;
    }
}