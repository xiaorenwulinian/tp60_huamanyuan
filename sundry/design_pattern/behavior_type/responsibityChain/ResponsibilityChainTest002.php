<?php

abstract class Manage
{
    protected $name;
    protected $superviorManager = null;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function setManage($manager){
         $this->superviorManager = $manager;
    }

    protected abstract function getApply($apply);
}

/**
 * 上级主管
 * Class CommonManage
 */
class CommonManage extends Manage
{

    public function getApply($apply)
    {
        // TODO: Implement getApply() method.
        // $apply.type  1,qingjia ,2 jiaxin
       if ($apply['type'] == 'qingjia' && $apply['num'] < 2) {
           echo 'deal person :'.$this->name .', qingjia ' . $apply['num'].' days common agree <br>';
       } else {
           if ($this->superviorManager != null) {
               $this->superviorManager->getApply($apply);
           }
       }
    }
}

/**
 * 总经理
 * Class MajorManage
 */
class MajorManage extends Manage
{
    public function getApply($apply)
    {
        // TODO: Implement getApply() method.
        // $apply.type  1,qingjia ,2 jiaxin
        if ($apply['type'] == 'qingjia' && $apply['num'] < 5) {
            echo 'deal person :'.$this->name .'， qingjia ' . $apply['num'].' days major agree <br>';
        } else {
            if ($this->superviorManager != null) {
                $this->superviorManager->getApply($apply);
            }
        }

    }
}

/**
 * 老板
 * Class BossManage
 */
class BossManage extends Manage
{
    public function getApply($apply)
    {
        // TODO: Implement getApply() method.
        // $apply.type  1,qingjia ,2 jiaxin
        if ($apply['type'] == 'qingjia') {
            if ($apply['num'] < 10) {
                echo 'deal person :'.$this->name .', qingjia ' . $apply['num'].' days boss agree <br>';
            } else {
                echo 'deal person :'.$this->name .', qingjia ' . $apply['num'].' days boss refuse <br>';
            }
        } else {
            if ( $apply['num'] <= 200) {
                echo 'deal person :'.$this->name .', jiaXin ' . $apply['num'].' yuan boss agree <br>';
            } else {
                echo 'deal person :'.$this->name .', jiaXin ' . $apply['num'].' yuan boss refuse <br>';
            }
        }

    }
}


demo();
function demo()
{

    $common = new CommonManage('common');
    $major = new MajorManage('major');
    $boss = new BossManage('boss');
    $common->setManage($major);
    $major->setManage($boss);
    $arr = [
        ['type'=>'qingjia','num'=>2], // 请假几天
        ['type'=>'qingjia','num'=>5],
        ['type'=>'qingjia','num'=>6],
        ['type'=>'qingjia','num'=>10],
        ['type'=>'qingjia','num'=>1],
        ['type'=>'jiaXin','num'=>200], // 加薪金额
        ['type'=>'jiaXin','num'=>600],
        ['type'=>'jiaXin','num'=>400],
    ];
    foreach ($arr as $v) {
        $common->getApply($v);
    }

 //Library/WebServer/Documents/test/design_pattern/responsibityChainPattern/ResponsibilityChainTest002.php

}
