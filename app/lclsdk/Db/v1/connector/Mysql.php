<?php
namespace app\lclsdk\Db\v1\connector;

use PDO;
use think\db\PDOConnection;

class Mysql extends PDOConnection
{
    /**
     * 解析pdo连接的dsn信息
     * @access protected
     * @param array $config 连接信息
     * @return string
     */
    protected function parseDsn(array $config): string
    {
        // TODO: Implement parseDsn() method.
    }

    /**
     * 取得数据表的字段信息
     * @access public
     * @param string $tableName 数据表名称
     * @return array
     */
    public function getFields(string $tableName): array
    {
        list($tableName) = explode(' ', $tableName);
        if (false === strpos($tableName, '`')) {
            if (strpos($tableName, '.')) {
                $tableName = str_replace('.','`.`', $tableName);
            }
            $tableName = '`' . $tableName . '`';
        }
        return [];

    }

    /**
     * 取得数据库的表信息
     * @access public
     * @param string $dbName 数据库名称
     * @return array
     */
    public function getTables(string $dbName): array
    {
        return [];

    }

}