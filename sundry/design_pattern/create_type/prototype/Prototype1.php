<?php

/**
 * 浅 copy, 仅仅是对象的引用，如果对象的属性仍是对象，则属性对象指向同一地址
 * Class User
 */
class User {

    private $attribute = [];
    public function __construct()
    {
    }

    public function __get($name)
    {
        if (!isset($this->attribute[$name])) {
            return " no attribute ! <br/>";
        }
        return $this->attribute[$name];
    }


    public function __set($name, $value)
    {
        $this->attribute[$name] = $value;
    }

    /**
     * 浅拷贝
     * @return User
     */
    public function shallowCopy()
    {
        return clone $this;
    }

    public function __clone()
    {
        return $this;
        // TODO: Implement __clone() method.
    }


    /*public function __clone()
    {
        return  $this;
        // TODO: Implement __clone() method.
        // deep clone (object attribute )
        $serialize = serialize($this);
        $clone = unserialize($serialize);
        return $clone;
        return unserialize(serialize($this));
        return $this;
    }*/


}
demo();
function demo()
{
    // test/design_java/create_type/prototype/Prototype.php
    $user = new User();
    $user->name = 'lcl';
    $user->age = 18;
    $friend = new User();
    $friend->name = 'jj';
    $friend->age = '19';
    $user->friend = $friend;
    print_r("user_age : {$user->age} <br/>");
    print_r("user_name : {$user->name} <br/>");
    print_r("user_friend_name : {$user->friend->name} <br/>");
    print_r("user_friend_age : {$user->friend->age} <br/>");

    $user1 = clone $user;
//    $user1 = $user->shallowCopy();

    print_r("user1_age : {$user1->age} <br/>");
    print_r("user1_name : {$user1->name} <br/>");
    print_r("user1_friend_name : {$user1->friend->name} <br/>");
    print_r("user1_friend_age : {$user1->friend->age} <br/>");

    $user->friend->age = 20;
    print_r("user_friend_age : {$user->friend->age} <br/>");
    print_r("user1_friend_age : {$user1->friend->age} <br/>");



//    echo ($user1);
//    var_dump($user1);
}

