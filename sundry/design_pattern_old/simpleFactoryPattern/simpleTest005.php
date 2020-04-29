<?php

/**
 *数据库工厂
 */
class database
{
	
	function __construct()
	{
		# code...
	}
    public  static  function  getInstance($config = ['type' => 'mysql','host'=>'127.0.0.1']){
        // 数据库的路径
        $className =  ucwords($config['type']);
        /*switch ($className) {
            case 'Mysql':
                $object = new Mysql($config);
                break;
            case 'Mongodb':
                $object = new Mongodb($config);
                break;
            case 'Sqlserver':
                $object = new Sqlserver($config);
                break;
        }*/
//        $extendPath = '/db/connector/'.$className .'php';
//        include $extendPath;
        $object = new $className($config);
        return $object;
    }


	
}




/*
 * 统一方法接口，子集实现
 */
abstract class DB
{
    protected $config = [
        'type' => 'mysql',
        'host' => '127.0.0.1',
        'database' =>'',
        'username' =>'',
        // ... 数据库的各项配置
    ];

    protected $instance ;



    protected abstract function insert($sql);
    protected abstract function update($sql);
    protected abstract function delete($sql);
    protected abstract function query($sql,$select);
}

class Mysql extends DB{
    public $db;
    public $conn;
    public function __construct($config)
    {
        $this->config = array_merge($this->config,$config);
        $this->conn = mysqli_connect($this->config['host'],$this->config['host'],$this->config['host'],$this->config['host']);

    }

    public function query($sql,$select) {
        $ret  =  mysqli_query($this->conn,$sql);
        $data = [];
        while($row = mysqli_fetch_array()($ret))
        {
            $temp = [];
            foreach ($select as $key) {
               $temp[$key] =  $row[$key];
            }
            $data[] = $temp;
        }
        return $data ;
    }

    public function insert($sql) {

        mysqli_query($this->conn,$sql);
        return true;

    }
    public function delete($sql) {
        mysqli_query($this->conn,$sql);
        return true;
    }

    protected  function update($sql){

    }
}

class Sqlserver extends Db{
    protected  function insert($sql){

    }
    protected  function update($sql){

    }
    protected  function delete($sql){

    }
    protected  function query($sql,$select){

    }
}

demo();
function demo(){

    $config = [
        'type'=>'mysql',
        'host'=>'127.0.0.1',
        'database'=>'test',
        'username'=>'root',
        'password'=>'root',
        'port'=>'3306',
    ];
    $db = database::getInstance($config);
    $sql = 'select name, pwd from user where id < 10 ';
    $ret = $db->query($sql);


    print_r($ret);
}




