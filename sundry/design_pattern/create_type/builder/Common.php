<?php

abstract class AbstractHouse {
    // 带地基
    public abstract function builderBasic();

    // 砌墙
    public abstract function builderWalls();

    // 封顶
    public abstract function roofed();

    // 开始构建
    public function build()
    {
        $this->builderBasic();
        $this->builderWalls();
        $this->roofed();
    }
}

class CommonHouse  extends AbstractHouse {
    public function builderBasic()
    {
        // TODO: Implement builderBasic() method.
        print_r("普通房子打地基 <br/>");
    }
    public function builderWalls()
    {
        // TODO: Implement builderWalls() method.
        print_r("普通房子 砌墙 <br/>");

    }

    public function roofed()
    {
        // TODO: Implement roofed() method.
        print_r("普通房子 封顶 <br/>");

    }
}

demo();
function demo()
{
    // test/design_java/create_type/builder/Common.php
    $commonHouse = new CommonHouse();
    $commonHouse->build();
}

