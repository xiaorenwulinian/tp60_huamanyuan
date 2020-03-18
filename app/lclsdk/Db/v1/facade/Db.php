<?php

namespace app\lclsdk\Db\v1\facade;


/**
 * Class Db
 * @package app\lclsdk\Db\v1\facade
 * @see \app\lclsdk\Db\v1\DbManager
 * @mixin \app\lclsdk\Db\v1\DbManager
 */
class Db extends Facade {

    protected static function getFacadeClass()
    {
        // 重写父级方法，调用真正都使用类，通过命名空间全路径 实例化
        return 'app\lclsdk\Db\v1\DbManager';
    }
}

