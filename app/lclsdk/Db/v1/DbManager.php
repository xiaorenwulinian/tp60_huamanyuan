<?php

namespace app\lclsdk\Db\v1;


use think\db\ConnectionInterface;

class DbManager
{

    /**
     * 数据库配置
     * @var array
     */
    protected $config = [];

    /**
     * 数据库链接实例
     * @var array
     */
    protected $instance = [];

    public function __construct()
    {
        $this->modelMark();
    }

    /**
     * 创建或切换数据库链接
     * @param string $name
     * @param bool $force
     */
    public function connect(string $name = null, $force = false)
    {
        // 获取当前连接器
        $connection = $this->instance($name, $force);
        // 获取当前连接器类对应的Query类
//      $queryClassName = $connection->getQueryClass();
        $queryClassName =  \think\db\Query::class;
        $query = new $queryClassName($connection); // 通过构造函数，在基类查询器中聚合连接器
        /*
//        $timeRule = $this->getConfig('time_query_rule'); // 获取时间查询规则
        $timeRule = config('database.time_query_rule'); // 获取时间查询规则
        if (!empty($timeRule)) {
            // 设置时间查询规则
            $query->timeRule($timeRule);
        }
        */
        return $query;
    }

    /**
     * 创建数据库连接实例
     * @param string $name 连接标识
     * @param bool $force 强制重新连接
     * @return mixed
     * @throws \Exception
     */
    protected function instance(string $name,bool $force = false)
    {
        if (empty($name)) {
            // 从 app/config 文件夹中读取配置信息，可以使用 default 或者自定义配置，方便多库切换
            $name = $this->getConfig('default', 'mysql');
        }

        if ($force || !isset($this->instance[$name])) {
            $this->instance[$name] = $this->createConnection($name);
        }
        return $this->instance[$name];
    }

    /**
     * 创建一个连接器对象
     * @param string $name
     * @return ConnectionInterface
     * @throws \Exception
     */
    protected function createConnection(string $name = 'mysql')
    {
        /*
       // 数据库连接配置信息
       'connections'     => [
           'mysql' => [
               // 数据库类型
               'type'              => Env::get('database.type', 'mysql'),
               // 服务器地址
               'hostname'          => Env::get('database.hostname', '127.0.0.1'),
               // 数据库名
               'database'          => /*Env::get('database.database', ''),
               // 用户名
               'username'          => Env::get('database.username', 'root'),
               // 密码
               'password'          => Env::get('database.password', ''),
               // 端口
               'hostport'          => Env::get('database.hostport', '3306'),
               // 数据库连接参数
               'params'            => [],
               // 数据库编码默认采用utf8
               'charset'           => Env::get('database.charset', 'utf8'),
               // 数据库表前缀
               'prefix'            => Env::get('database.prefix', ''),

               // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
               'deploy'            => 0,
               // 数据库读写是否分离 主从式有效
               'rw_separate'       => false,
               // 读写分离后 主服务器数量
               'master_num'        => 1,
               // 指定从服务器序号
               'slave_no'          => '',
               // 是否严格检查字段是否存在
               'fields_strict'     => true,
               // 是否需要断线重连
               'break_reconnect'   => false,
               // 监听SQL
               'trigger_sql'       => true,
               // 开启字段缓存
               'fields_cache'      => false,
               // 字段缓存路径
               'schema_cache_path' => app()->getRuntimePath() . 'schema' . DIRECTORY_SEPARATOR,
           ],

           // 更多的数据库配置信息
       ],
       */
        // 获取数据库连接配置信息
        $connections = $this->getConfig('connections');
        if (!isset($connections[$name])) {
            throw new \Exception("未定义数据库连接配置：" . $name);
        }
        $config =  $connections[$name];
        $type = $config['type'] ?? 'mysql'; // 数据库类型 ，mysql,oracle ...
        if (false !== strpos($type, '\\')) {
            // 包含命名空间的类
            $ConnectionClass = $type;
        } else {
            // 默认的连接器，后续自定义连接器
            $ConnectionClass = "\\think\\db\\connector\\" . ucfirst($type);
//            $ConnectionClass = "\\app\\lclsdk\\Db\v1\\connector\\" . ucfirst($type);
        }
        /** @var ConnectionInterface $connection */
        $connection = new $ConnectionClass($config); // 在连接器构造方法中设置生成器（驱动）
        // 设置当前的数据库Db对象,以聚合模式传参设置，此方法在基类 Connection 中
        $connection->setDb($this);
        return $connection;
    }


    /**
     * 初始化配置参数
     * @param $config
     */
    public function setConfig($config) :void
    {
        $this->config = $config;
    }

    /**
     * 获取配置参数
     * @param string $name
     * @param null $default
     * @return array
     */
    public function getConfig(string $name, $default = null)
    {
        if ($name === '') {
            return $this->config;
        }
        return $this->config[$name] ?? $default;
    }

    public function modelMark()
    {

    }
}

