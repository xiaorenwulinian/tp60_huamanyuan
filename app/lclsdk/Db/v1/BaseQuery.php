<?php

namespace app\lclsdk\Db\v1;

use think\Config;
use think\db\Connection;
use think\db\ConnectionInterface;
use think\helper\Str;

abstract class BaseQuery
{

    /**
     * 当前数据库连接对象
     * @var Connection
     */
    protected $connection;
    /**
     * 当前查询参数
     * @var array
     */
    protected $options = [];

    /**
     * 当前数据表名称
     * @var string
     */
    protected $name = '';
    /**
     * 架构函数
     * @access public
     * @param ConnectionInterface $connection 数据库连接对象
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }
    /**
     * 指定当前操作的数据表
     * @param mixed $table 表名
     * @return $this
     */
    public  function table($table)
    {
        $this->options['table'] = $table;
        return $this;
    }


    /**
     * 指定数据表别名
     * @param string $alias
     * @return $this
     */
    public function alias(string $alias = '')
    {
        $table = $this->getTable();
        $this->options['alias'] = $alias;
        return $this;
    }

    /**
     * 获取指定名称的数据表名
     * @param string $name
     * @return mixed|string
     */
    public function getTable(string $name = '')
    {
        if (empty($name) && isset($this->options['table'])) {
            return $this->options['table'];
        }
        $name = $name ? : $this->name;
        // 表名驼峰转下划线
        $name = Str::snake($name);
        return $name;
    }

    /**
     * 排序
     * @param $field
     * @param string $order
     * @return $this
     */
    public function order($field, string $order = '')
    {

        return $this;
    }

    /**
     * 查询指定字段
     * @param string $field
     * @return $this
     */
    public function field($field = '')
    {
        if (empty($field)) {
            return $this;
        }
        if (is_string($field)) {
            $field = array_map('trim', explode(',', $field));
        }
        if (isset($this->options['field'])) {
            $field =  array_merge($this->options['field'], $field);
        }
        $this->options['field'] = $field;
        return $this;
    }

    /**
     * 查询
     * @return array
     */
    public function select()
    {
        $resultSet = $this->connection->select($this);
        return $resultSet;

    }
}