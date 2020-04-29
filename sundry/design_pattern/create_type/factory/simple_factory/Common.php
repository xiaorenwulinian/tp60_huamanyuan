<?php

/**
 * Class Sweater 毛衣
 */
class Sweater {

    public $name ;

    public function __construct($name)
    {
        $this->name = $name;
    }

    function buyMaterial() {
        print_r(" 购买 {$this->name} 原材料 - 毛线! <br> ");
    }

    function productDeal() {
        print_r(" 加工生产 {$this->name} ! <br>");
    }

    function package() {
        print_r(" 包装 {$this->name} ! <br>");
    }
}

/**
 * Class Jeans 牛仔裤
 */
class Jeans{
    public $name ;

    public function __construct($name)
    {
        $this->name = $name;
    }

    function buyMaterial() {
        print_r(" 购买 {$this->name} 原材料 - 牛仔布! <br> ");
    }

    function productDeal() {
        print_r(" 加工生产 {$this->name} ! <br>");
    }

    function package() {
        print_r(" 包装 {$this->name} ! <br>");
    }
}

/**
 * Class Shirt 衬衫
 */
class Shirt {
    public $name ;
    public function __construct($name)
    {
        $this->name = $name;
    }

    function buyMaterial() {
        print_r(" 购买 {$this->name} 原材料 -  纯棉布! <br> ");
    }

    function productDeal() {
        print_r(" 加工生产 {$this->name} ! <br>");
    }

    function package() {
        print_r(" 包装 {$this->name} ! <br>");
    }

}


class OrderClothing {

    public function __construct()
    {

    }

    public function order($orderType)
    {
        print_r("购买类型：  {$orderType} ! <br>" );

        $clothing = '';
        switch ($orderType) {
            case 'shirt' :
                $clothing = new Shirt($orderType);
                break;
            case 'jeans' :
                $clothing = new Jeans($orderType);
                break;
            case 'sweater' :
                $clothing = new Sweater($orderType);
                break;
        }
        if (empty($clothing)) {
            exit("未发现该服装！");
        }
        $clothing->buyMaterial();
        $clothing->productDeal();
        $clothing->package();

    }

}

demo();

function demo ()
{
    // test/design_java/create_type/factory/simple_factory/Common.php
    // 普通方法调用
    $type = ['shirt', 'jeans', 'sweater'];
    $orderType =  $type[rand(0, count($type) - 1)];
    $orderClothing = new OrderClothing();
    $orderClothing->order($orderType);
}
