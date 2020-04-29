<?php

class WebsiteFactory {
    private static $container ;

    public static function getWebsiteCategory($type)
    {
        if (!isset(self::$container[$type]) || empty(self::$container[$type])) {
            self::$container[$type] = new ConcreteWebsite($type);
        }
        return self::$container[$type];
    }
    public static function getWebsiteCount()
    {
        return count(self::$container);
    }
}

class ConcreteWebsite  {

    private  $type;
    public function __construct($type)
    {
        $this->type = $type;
    }

    public function used(User $user)
    {
        print_r("网站的发布形式为: {$this->type} 在使用中 .. 使用者是 {$user->getName()} <br/>");
    }
}

/**
 * Class Userd
 *
 */
class User {
    private $name;
    public function __construct($name)
    {
        $this->name = $name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
}

demo();

function demo() {
    // stucture_type/facade/Facade.php


    $count = WebsiteFactory::getWebsiteCount();
    print_r("当前容器数量: {$count} <br/>");
    $factory1 = WebsiteFactory::getWebsiteCategory('新闻');
    $factory1->used();
    $factory1 = WebsiteFactory::getWebsiteCategory('新闻');


}



