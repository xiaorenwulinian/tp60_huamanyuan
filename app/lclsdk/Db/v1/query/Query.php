<?php

namespace app\lclsdk\Db\v1\query;

use app\lclsdk\Db\v1\connector\MysqlConnction;
use think\Config;
use think\db\Connection;
use think\helper\Str;

class Query
{

    /**
     * @var MysqlConnction
     */
    public $connection;

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
     * 指定当前操作的数据表
     * @param mixed $table 表名
     * @return $this
     */
    public function table($table)
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
        // 获取当前表名
        $tableName = $this->getTable();
        // 考虑多表关联，需要多维数组
        $this->options['alias'][$tableName] = $alias;
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
    public function order($field = '', string $order = 'asc')
    {
        if (empty($field)) {
            return $this;
        }
        $curFieldOrder = [$field => $order];
        if (!isset($this->options['order'])) {
            $this->options['order'] = [];
        }
        /*
        支持多字段排序
        多次调用 order(),第一次 order('age','desc'), 第二次 order('type', 'desc');
        则最终排序
        $order = [
            'age' => 'desc',
            'type' => 'desc',
        ];
        */
        $this->options['order'] = array_merge($this->options['order'], $curFieldOrder);
        return $this;
    }

    /**
     *
     */
    public function select()
    {
        $result = $this->connection->select($this);
       return $result;
    }
}