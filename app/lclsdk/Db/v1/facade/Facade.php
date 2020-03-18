<?php

namespace app\lclsdk\Db\v1\facade;


/**
 * 所有都门面基类，Db, Cache, Redis ...
 * Class Facade
 * @package app\lclsdk\Db\v1\facade
 */
class Facade {

    /*
     * 始终获取新的对象实例
     * @var bool
     */
    protected static $alwaysNewInstance;

    protected static $instance;

    /**
     * 获取当前 facade 对应的类名
     */
    protected static function getFacadeClass()
    {}


    /**
     * 创建 Facade 实例
     * @param bool $newInstance 是否每次都创建实例
     * @return mixed
     */
    protected static function createFacade(bool $newInstance = false)
    {
        $class = static::getFacadeClass() ?? 'app\lclsdk\Db\v1\DbManager';
        if (static::$alwaysNewInstance) {
            $newInstance = true;
        }
        if ($newInstance) {
            return new $class;
        }
        if (!self::$instance) {
            self::$instance = new $class;
        }
        return self::$instance;
    }

    /**
     * 静态回调方法
     * @param $method
     * @param $arguments
     * @return mixed
     */
    public static function __callStatic($method, $arguments)
    {
        // TODO: Implement __callStatic() method.
        return call_user_func_array([static::createFacade(), $method], $arguments);
    }
}


