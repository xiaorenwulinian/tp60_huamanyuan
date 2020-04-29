<?php
/**
 * 接口适配器，将 220v 电压经过适配器转换成 5v
 * 取消继承，使用匿名函数实现接口
 */

/**
 * Interface IVoltageMultiV 适配器接口,适配多个电压
 */
interface IVoltageMultiV
{
    /**
     * @return mixed 输出 5V 电压
     */
    public function output5V();

    /**
     * @return mixed 输出 10V 电压
     */
    public function output10V();
}

/**
 * Class VoltageAdapter 适配器
 * 实现所有允许的 电压转换，默认空方法，具体用哪个方法，匿名函数实现
 */
abstract  class VoltageAdapter implements IVoltageMultiV
{
    public function output10V()
    {
        // TODO: Implement output10V() method.
    }

    public function output5V()
    {
    }

}

class VoltageAdapter5V extends VoltageAdapter
{
    public function output5V()
    {
        $src = 220;
        print_r("==电压 {$src} 伏== <br/>");
        return $src;
    }
}


/**
 * Class Phone 手机
 */
class Phone
{
    /**
     * 手机充电
     */
    public function charging(IVoltageMultiV $iVoltage5V)
    {
        if ($iVoltage5V->output5V() == 5) {
            print_r("====配器成功，电压5V 可以充电====<br/>");
        } else {
            print_r("====电压不稳 不可以充电====<br/>");
        }
    }
}

demo();
function demo() {
    // stucture_type/adapter/InterfaceAdapter.php
    print_r("==== 接口适配器 ====<br/>");
    $phone = new Phone();
    $phone->charging(new VoltageAdapter5V());
    /**
    new VoltageAdapter() {
        // 匿名内部类中覆盖父类方法，php 不支持该方法，需先建立相应的子类实现抽象类，
        // 如果仍需要编写相应的子类，可使用其他设计模式
        // PHP 太多的局限性
        // TODO: Implement output5V() method.
        public function output5V()
        {
            $src = 220;
            print_r("==电压 {$src} 伏== <br/>");
            return $src;
        }
    };
    */
}
