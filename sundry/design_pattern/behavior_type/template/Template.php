<?php

abstract class Model
{
    public $data = [];
    public final function create($data)
    {
        $this->data = $data;
         // 添加前
        $this->hookEvent("before_insert");

        // 开始添加
        $this->insert($data);

        // 添加后
        $this->hookEvent("after_insert");
    }

    public function insert($data)
    {
        $newPkId = rand(10,1000);
        echo "===开始添加:" . "<br/>"
            . "添加成功，生成主键ID：" . $newPkId . "<hr/>";

        $this->data = array_merge($this->data, ["id" => $newPkId]);
    }


    /**
     * 钩子行为，添加前，添加后，修改前，修改后， 让子类去定义重写方法
     * @param $eventName
     */
    public function hookEvent($eventName) {

        // 下划线转驼峰
        $method =  'on' . str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $eventName)));

        if (method_exists($this, $method)) {
            call_user_func([$this,$method], $this);
        }

    }
}

class UserModel extends Model {
    public function OnBeforeInsert($user)
    {

        $data = $user->data;

        echo "==用户添加前,添加数据 :" . "<br/>";
        print_r($data);
        echo "<br/>";
        // 模拟修改器，修改 age 属性 ；
        $user->data['age'] = "age_" . $user->data['age'];
        echo "<hr/>";


    }

    public function OnAfterInsert($user)
    {

        echo "用户添加后，新数据" . "<br/>";
        print_r($user);
        echo "<br/>";
    }
}

test();

function test(){
 // design_java/behavior_type/template/Template.php
    $user = new UserModel();
    $insertData = [
        'name' => 'tom',
        'age'  => '18',
    ];
    $user->create($insertData);
}



