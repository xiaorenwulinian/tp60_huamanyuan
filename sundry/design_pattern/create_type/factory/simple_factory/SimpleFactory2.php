<?php


abstract class Clothing {
    public $name ;

    public function __construct() {}

    // 服装操作变化的内容
    public abstract function  buyMaterial();

    public function productDeal() {
        print_r(" 加工生产 {$this->name} ! <br>");
    }

    public function package() {
        print_r(" 包装 {$this->name} ! <br>");
    }

    public function setName($name)
    {
        $this->name = $name;
    }

}
/**
 * Class Sweater 毛衣
 */
class Sweater extends Clothing {

    public function buyMaterial()
    {
        // TODO: Implement buyMaterial() method.
        print_r(" 购买 {$this->name} 原材料 - 毛线! <br> ");
    }
}

/**
 * Class Jeans 牛仔裤
 */
class Jeans extends Clothing {

    public function buyMaterial()
    {
        // TODO: Implement buyMaterial() method.
        print_r(" 购买 {$this->name} 原材料 - 牛仔布! <br> ");
    }
}

/**
 * Class Shirt 衬衫
 */
class Shirt extends Clothing {

    public function buyMaterial()
    {
        // TODO: Implement buyMaterial() method.
        print_r(" 购买 {$this->name} 原材料 -  纯棉布! <br> ");
    }

}


class SimpleFactory {

    public  function createClothing($orderType)
    {
        print_r(" 使用简单工厂 == 选择工厂! <br> ");
        $clothing = '';
        switch ($orderType) {
            case 'shirt' :
                $clothing = new Shirt();
                $clothing->setName($orderType);
                break;
            case 'jeans' :
                $clothing = new Jeans();
                $clothing->setName($orderType);
                break;
            case 'sweater' :
                $clothing = new Sweater();
                $clothing->setName($orderType);
                break;

        }
        return $clothing;
    }
}

class OrderClothing {

    private $simpleFactory ;
    public function __construct()
    {

    }

    public function setFactory($simpleFactory)
    {
        $this->simpleFactory = $simpleFactory;
    }

    public function order($orderType)
    {
        print_r("购买类型：  {$orderType} ! <br>" );
        /**
         * 简单工厂,获取相应的工厂，从工厂中获取 相应类型的服装对象
         */
       $clothing = $this->simpleFactory->createClothing($orderType);
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
    //  test/design_java/create_type/factory/simple_factory/SimpleFactory2.php
    $type = ['shirt', 'jeans', 'sweater'];
    $orderType =  $type[rand(0, count($type) - 1)];
    // 简单工厂
    $orderClothing = new OrderClothing();
    // 设置相应的工厂
    $orderClothing->setFactory(new SimpleFactory());
    $orderClothing->order($orderType);
}