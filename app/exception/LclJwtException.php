<?php

namespace app\exception;

use Throwable;

class LclJwtException extends  \RuntimeException
{
    
    protected $message = '认证失败，暂无权限';
    protected $code = 401;
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $this->message = $message;
        $this->code = $code;
    }
}
