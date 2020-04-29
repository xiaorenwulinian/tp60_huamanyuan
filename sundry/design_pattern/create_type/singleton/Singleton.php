<?php

class UserModel {
    private static $instance = null;

    /**
     * 私有化构建方法，防止直接创建对象
     */
    private function __construct()
    {
        print_r("禁止直接创建对象 <br/>");
    }

    /**
     * 获取对象唯一入口
     * @return UserModel
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function add()
    {
        print_r(" add info <br/>");
    }

    public function select()
    {
        print_r(" select info <br/>");
    }

    public function update()
    {
        print_r(" update info <br/>");
    }

    public function delete()
    {
        print_r(" delete info <br/>");
    }

    /**
     * 私有化克隆方法
     */
    private function __clone()
    {
        // TODO: Implement __clone() method.
    }
}

demo();

function demo()
{
    // test/design_java/create_type/singleton/Singleton.php
    $user = UserModel::getInstance();
    $user->add();
    $user->update();
}
