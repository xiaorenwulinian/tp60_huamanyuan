<?php
/**
 * 对象适配器，将 220v 电压经过适配器转换成 5v
 * 取消继承，避免单继承带来的局限性，使用聚合 构造器传参 实现
 */

/**
 * Interface IVoltage5V 适配器接口
 */
interface IVoltage5V
{
    public function output5V();
}

/**
 * 被适配的类 电压 220V
 * Class Voltage220V
 */
class Voltage220V
{
    public function output()
    {
        $src = 220;
        print_r("==电压 {$src} 伏== <br/>");
        return $src;
    }
}

/**
 * Class VoltageAdapter 适配器
 * 取消继承，使用聚合 构造器传参
 */
class VoltageAdapter implements IVoltage5V
{
    private $voltage220V = null;
    public function __construct(Voltage220V $voltage220V)
    {
        $this->voltage220V = $voltage220V;
    }

    public function output5V()
    {
        if (!is_null($this->voltage220V)) {
            // TODO: Implement output5V() method.
            $oriSrcV = $this->voltage220V->output();
            $transferSrcV = $oriSrcV / 44; // 220V -> 5V
            return $transferSrcV;
        }
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
    public function charging(IVoltage5V $iVoltage5V)
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
    // stucture_type/adapter/ObjectAdapter.php
    print_r("==== 对象适配器 ====<br/>");
    $phone = new Phone();
    $phone->charging(new VoltageAdapter(new Voltage220V()));
}
