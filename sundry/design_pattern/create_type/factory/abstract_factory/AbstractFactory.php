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
 * Class Sweater 中国毛衣
 */
class ChinaSweater extends Clothing {

    public function buyMaterial()
    {
        // TODO: Implement buyMaterial() method.
        print_r(" 购买 {$this->name} 原材料 - 毛线! <br> ");
    }
}

/**
 * Class Jeans 中国牛仔裤
 */
class ChinaJeans extends Clothing {

    public function buyMaterial()
    {
        // TODO: Implement buyMaterial() method.
        print_r(" 购买 {$this->name} 原材料 - 牛仔布! <br> ");
    }
}

/**
 * Class Sweater 日本毛衣
 */
class JapanSweater extends Clothing {

    public function buyMaterial()
    {
        // TODO: Implement buyMaterial() method.
        print_r(" 购买 {$this->name} 原材料 - 毛线! <br> ");
    }
}

/**
 * Class Jeans 日本牛仔裤
 */
class JapanJeans extends Clothing {

    public function buyMaterial()
    {
        // TODO: Implement buyMaterial() method.
        print_r(" 购买 {$this->name} 原材料 - 牛仔布! <br> ");
    }
}

interface AbstractClothingFactory {
    public function createClothing($clothingType);
}

class ChinaClothingFactory implements AbstractClothingFactory {
    public function createClothing($clothingType)
    {
        // TODO: Implement createClothing() method.
        print_r(" 使用抽象工厂方式 == 产地中国! <br> ");
        $clothing = '';
        switch ($clothingType) {
            case 'jeans' :
                $clothing = new ChinaJeans();
                $clothing->setName('china jeans ');
                break;
            case 'sweater' :
                $clothing = new ChinaSweater();
                $clothing->setName('china sweater ');
                break;

        }
        return $clothing;
    }
}

class JapanClothingFactory implements AbstractClothingFactory {
    public function createClothing($clothingType)
    {
        // TODO: Implement createClothing() method.
        print_r(" 使用抽象工厂方式 == 产地日本! <br> ");
        $clothing = '';
        switch ($clothingType) {
            case 'jeans' :
                $clothing = new JapanJeans();
                $clothing->setName('japan jeans ');
                break;
            case 'sweater' :
                $clothing = new JapanSweater();
                $clothing->setName('japan sweater ');
                break;

        }
        return $clothing;
    }
}


class OrderClothing {
    private $factory;

    public function setFactory($factory) {
        $this->factory = $factory;
    }

    public function order($orderType)
    {
        $clothing = $this->factory->createClothing($orderType);
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
    // test/design_java/create_type/factory/abstract_factory/AbstractFactory.php
    $countryTypeArr  = ['china', 'japan'];
    $countryType =  $countryTypeArr[rand(0,count($countryTypeArr)-1)]; // 国家类型
    $clothingTypeArr  = ['jeans', 'sweater'];
    $clothingType =  $clothingTypeArr[rand(0,count($clothingTypeArr)-1)]; // 衣服类型
    switch ($countryType) {
        case 'china':
            $orderClothing = new OrderClothing();
            $orderClothing->setFactory(new ChinaClothingFactory());
            $orderClothing->order($clothingType);
            break;
        case 'japan':
            $orderClothing = new OrderClothing();
            $orderClothing->setFactory(new JapanClothingFactory());
            $orderClothing->order($clothingType);
            break;
    }

}