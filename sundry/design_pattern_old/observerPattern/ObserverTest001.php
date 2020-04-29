<?php

/**
*事件基类
*/

class EventGenerator
{
    private $observersArr = [];

    /**
     * 存入监听者，一个事件可以有多个监听者
     * @param $observer 监听者对象
     */
    public function addAttach($observer)
    {
        if (!in_array($observer, $this->observersArr)) {
           $this->observersArr[] = $observer;
        }
    }

    /**
     * 开启事件
     */
    public function startNotifyAllObservers()
    {
        foreach ($this->observersArr as $observer) {
            $observer->handle();
        }
    }
}


/**
 * 事件和监听器，事件构造函数激活时，绑定的监听器，监听并完成具体的功能。
 * 测试用户注册后，发送短信和发送邮件两个监听器，
 * Class Event
 */
class Event extends EventGenerator
{

    public $userId ;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
    *事件监听触发
    */
    public function trigger() {
        $this->startNotifyAllObservers();
    }
}

abstract class Observer
{
    protected $event;

    /**
     * 监听事件后具体的处理方法
     * @return mixed
     */
    public  abstract  function handle();
}

class MailObserver extends Observer
{
    public function __construct($event)
    {
        $this->event = $event;
        $this->event->addAttach($this);
    }

    public function handle()
    {
        // TODO: Implement handle() method.
        $userId = $this->event->userId;

        echo "===send mail to {$userId}== <br/>";
    }
}

class SmsObserver extends Observer
{
    public function __construct($event)
    {
        $this->event = $event;
        $this->event->addAttach($this);
    }

    public function handle()
    {
        // TODO: Implement handle() method.
        $userId = $this->event->userId;

        echo "===send sms to {$userId}== <br/> ";
    }
}

demo();

function demo()
{
    $uid = 3;
    $event = new Event($uid);
    new MailObserver($event); // 绑定事件
    new SmsObserver($event); // 多次绑定
    $event->trigger(); // 开始监听

}