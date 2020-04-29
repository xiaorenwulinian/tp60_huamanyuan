<?php

/**
 * 单例模式，
 * 1.私有化对象属性
 * 2.私有化构造器
 * 3.私有化clone魔术方法
 * 4公有化单一入口文件，实例化唯一对象
 * Class DB
 */
class DB {

    private static $db;

    private function __construct()
    {
        echo '正在构建对象，私有化构造器，防止被重复构建新的对象 <br/>';
    }

    /**
     * 构建对象唯一入口
     */
    public static function getInstance()
    {
        if (is_null(static::$db)) {
            print_r('开始构建对象 <br/>');
            self::$db = new self();
        }
        return self::$db;
    }

    /**
     * 禁止克隆对象
     */
    private function __clone()
    {
        // TODO: Implement __clone() method.
        print_r('void clone object <br/>');
    }

    public function insert()
    {
        print_r('database insert! <br/>') ;
    }

    public function update()
    {
        print_r('database update <br/>');
    }

}

demo();

function demo()
{
    $db1 =  DB::getInstance();
    $db1->insert();
    $db2 =  DB::getInstance();
    $db2->update();

}