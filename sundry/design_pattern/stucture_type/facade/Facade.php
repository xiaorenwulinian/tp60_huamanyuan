<?php

class HomeTheaterFacade {

    private $theaterLight; // 剧院灯光
    private $stereo; // 立体声
    private $projector; // 投影仪
    private $dVDPlayer; // 播放器
    public function __construct()
    {
        $this->dVDPlayer = DVDPlayer::getInstance();
        $this->projector = Projector::getInstance();
        $this->stereo    = Stereo::getInstance();
        $this->theaterLight = TheaterLight::getInstance();
    }

    /**
     * 一键开所有
     */
    public function on()
    {
        $this->dVDPlayer->on();
        $this->projector->on();
        $this->stereo->on();
        $this->theaterLight->on();
    }

    /**
     * 一键关机
     */
    public function off()
    {
        $this->dVDPlayer->off();
        $this->projector->off();
        $this->stereo->off();
        $this->theaterLight->off();
    }
    public function player()
    {
        $this->dVDPlayer->play();
    }
    /**
     * 声音调大
     */
    public function up()
    {
        $this->stereo->up();
    }
    /**
     * 声音调小
     */
    public function down()
    {
        $this->stereo->down();
    }
    /**
     *  灯光变亮
     */
    public function lighter()
    {
        $this->theaterLight->lighter();
    }
    /**
     * 灯光调暗
     */
    public function dark()
    {
        $this->theaterLight->dark();
    }
}

class TheaterLight
{
    private static $instance;
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }
    public function on()
    {
        print_r(" heaterLight on <br/>");
    }
    public function off()
    {
        print_r(" heaterLight off <br/>");
    }
    public function lighter()
    {
        print_r(" heaterLight lighter <br/>");
    }
    public function dark()
    {
        print_r(" heaterLight dark <br/>");
    }
}
class Stereo
{
    private static $instance;
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }
    public function on()
    {
        print_r(" stereo on <br/>");
    }
    public function off()
    {
        print_r(" stereo off <br/>");
    }
    public function up()
    {
        print_r(" stereo up <br/>");
    }
    public function down()
    {
        print_r(" stereo down <br/>");
    }
}

class Projector
{
    private static $instance;
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }
    public function on()
    {
        print_r(" projector on <br/>");
    }
    public function off()
    {
        print_r(" projector off <br/>");
    }

}


class DVDPlayer
{
    private static $instance;
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }
    public function on()
    {
        print_r(" dvd on <br/>");
    }
    public function play()
    {
        print_r(" dvd play <br/>");
    }
    public function off()
    {
        print_r(" dvd off <br/>");
    }
    public function pause()
    {
        print_r(" dvd pause <br/>");
    }
}

demo();

function demo() {
    // stucture_type/facade/Facade.php

    /**
     * 家庭影院，DVD播放器，投影仪，音响，灯光
     */

    $homeTheaterFacade = new HomeTheaterFacade();
    $homeTheaterFacade->on();
    $homeTheaterFacade->player();
    $homeTheaterFacade->lighter();
    $homeTheaterFacade->up();
    $homeTheaterFacade->off();

}



