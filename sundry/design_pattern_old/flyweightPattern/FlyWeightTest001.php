<?php


interface Shape
{
    public function draw();
}

class CircleShape implements Shape
{
    private $color;

    public function __construct($color)
    {
        $this->color = $color;
    }

    public function draw()
    {
        // TODO: Implement draw() method.
        echo '=color:' . $this->color . '=<br>';
    }

}

class ShapeFactory
{
    private static $circleArr = [];

    public static function getCircle($color)
    {
        if (!isset(static::$circleArr[$color]) || empty(static::$circleArr[$color])) {
            static::$circleArr[$color] =  new CircleShape($color);
            echo '===create circle ,color:' . $color . ' === <br/>';
        }
        return static::$circleArr[$color];
    }
}

demo();

function demo()
{
    $colors = [
        'red','blue','grey','white'
    ];
    for ($i = 0; $i < 20; $i++) {
        $circle = ShapeFactory::getCircle($colors[rand(0,count($colors)-1)]);
        $circle->draw();
    }
}
