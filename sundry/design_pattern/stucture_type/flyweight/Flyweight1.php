<?php


/**
 * Class Container
 * @method UserModel userModel()
 */
class Container {
    private static $container;

    public static function getInstance($className)
    {
        if (!isset(self::$container[$className]) || empty(self::$container[$className])) {
            $reflect = new \ReflectionClass($className);
            self::$container[$className] = $reflect->newInstance();
        }
        return self::$container[$className];
    }
}

class UserModel extends Container {
    public function query()
    {
        print_r("用户查询 === <br/>");
    }
    public function insert()
    {
        print_r("用户添加 === <br/>");
    }
}

class Cache extends Container {
    private static $cacheArr;
    public  function set($key, $value)
    {
        self::$cacheArr[$key] = $value;
        print_r("缓存中存入 key: {$key}== value: {$value}  <br/>");
    }
    public function get($key)
    {
        if (array_key_exists($key, self::$cacheArr)) {
            $value = self::$cacheArr[$key];
            print_r("缓存中取出 key: {$key} === value: {$value} <br/>");
            return self::$cacheArr[$key];
        }
        print_r("缓存中取出 key: {$key} === value: null <br/>");
        return null;
    }
}
demo();

function demo() {
    // stucture_type/flyweight/Flyweight1.php

    $userModel = Container::getInstance(UserModel::class);

    $userModel->query();
    $userModel->insert();

    $cache = Container::getInstance(Cache::class);
    $cache->set('age', 18);
    $cache->get('age');
    $cache = Container::getInstance(Cache::class);

    $cache->set('age', 20);
    $cache->get('name');
}



