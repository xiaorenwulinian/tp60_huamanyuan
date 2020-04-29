<?php

/**
 * 图形形状
 */
abstract class Shape
{
    protected $color;
    public  function setColor($color)
    {
        $this->color = $color;
    }

    public abstract function draw();

}

class CircleShape extends Shape
{
    public function draw()
    {
        $this->color->paint('circle shape');
    }
}

class RectangleShape extends Shape
{
    public function draw()
    {
        $this->color->paint('rectangle shape');
    }
}


interface Color
{
    /**
     *
     * @param $shape 绘画的形状
     * @return mixed
     */
    public function paint(Shape $shape);
}

class RedColor implements Color
{

    public function paint($shape)
    {
       echo '==red : ' . $shape . '== <br>';
    }

}

class BlackShape implements Color
{

    public function paint($shape)
    {
        echo '==black : ' . $shape . '== <br>';
    }

}

aaa();
function aaa()
{
    $circleShape = new CircleShape();
    $circleShape->setColor(new RedColor());
    $circleShape->draw();

    $rectangle = new RectangleShape();
    $rectangle->setColor(new BlackShape());
    $rectangle->draw();
}
