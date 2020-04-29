<?php

/**
 * 需要建者的物品（房子）
 * Class House
 */
class House
{
    private $base;   // 地基
    private $wall;   // 墙
    private $roofed; // 屋顶

    public function setBase($base)
    {
        $this->base = $base;
    }
    public function getBase()
    {
        return $this->base;
    }
    public function setWall($wall)
    {
        $this->wall = $wall;
    }
    public function getWall()
    {
        return $this->wall;
    }
    public function setRoofed($roofed)
    {
        $this->roofed = $roofed;
    }
    public function getRoofed()
    {
        return $this->roofed;
    }
}

/**
 * 房子抽象构建者
 * Class HouseBuilder
 */
abstract class HouseBuilder
{
    protected $house ;
    public abstract function buildBase();   // 打地基
    public abstract function buildWalls();  // 砌墙
    public abstract function buildRoofed(); // 封顶

    /**
     * @return House 建造房子各个步骤完成后， 返回建造好的房子
     */
    public function buildHouse()
    {
        $this->house = new House();
        return $this->house;
    }
}

/**
 * 具体构建者 低层房屋
 * Class LowerHouse
 */
class LowerHouse extends HouseBuilder
{
    public function buildBase()
    {
        // TODO: Implement buildBase() method.
        print_r("低层房子打地基 深5m <br/>");
    }
    public function buildWalls()
    {
        // TODO: Implement buildWalls() method.
        print_r("低层房子砌墙 普通材料 <br/>");

    }
    public function buildRoofed()
    {
        // TODO: Implement buildRoofed() method.
        print_r("低层房子 封顶 使用石板 <br/>");
    }
}

/**
 * 具体构建者 别墅
 * Class Villa
 */
class Villa extends HouseBuilder
{
    public function buildBase()
    {
        // TODO: Implement buildBase() method.
        print_r("别墅房子打地基 深10m <br/>");
    }
    public function buildWalls()
    {
        // TODO: Implement buildWalls() method.
        print_r("别墅房子砌墙 豪华环保材料 <br/>");

    }
    public function buildRoofed()
    {
        // TODO: Implement buildRoofed() method.
        print_r("别墅房子封顶 使用砖瓦雕刻 <br/>");
    }
}

/**
 * 指挥者
 * Class HouseDirector
 */
class HouseDirector
{
    public $houseBuilder = null; // 建造的房屋种类
    /**
     * 通过setter 传入 houseBuilder
     * @param HouseBuilder $houseBuilder
     */
    public function setHouseBuilder(HouseBuilder $houseBuilder)
    {
        $this->houseBuilder = $houseBuilder;
    }

    public function constructHouse()
    {
        $this->houseBuilder->buildBase();
        $this->houseBuilder->buildWalls();
        $this->houseBuilder->buildRoofed();
        return $this->houseBuilder->buildHouse();
    }

}
demo();
function demo()
{
    // test/design_java/create_type/builder/Builder.php
    $houseDirector = new HouseDirector();
    // 选择建造者,如使用 mysql 生成器
    $houseDirector->setHouseBuilder(new LowerHouse());
    //完成盖房子，返回产品(低层房子)
    $house = $houseDirector->constructHouse();
//    var_dump($house);
    print_r("房子盖好 <hr/>");


    // 重置建造者
    $houseDirector->setHouseBuilder(new Villa());
    //完成盖房子，返回产品(别墅房子)
    $house = $houseDirector->constructHouse();
//    var_dump($house);


}

