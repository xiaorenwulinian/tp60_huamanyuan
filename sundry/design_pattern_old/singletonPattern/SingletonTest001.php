<?php

/**
 * 未实现单例模式，会多次生产对象
 * Class DB
 */
class DB {

    private static $db;

    public function __construct()
    {
        echo '构建新的对象 <br/>';
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
    $db1 =  new DB();
    $db1->insert();
    $db2 =  new DB();
    $db2->update();
}