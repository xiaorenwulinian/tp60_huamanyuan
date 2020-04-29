<?php
/**
 * 以计算器为例
 */
class Calculator
{
	
	public function __construct()
	{
		
	}

	public function getResult($a, $b)
	{


//		$operObj = OperatorFactory::createOperator($operator);
//		return $operObj->getResult($a, $b);
		// return call_user_func_array([new Operator(),$operate], [$a,$b]);
	}

}

/**
 * 策略类 （与工厂类不同之处）
 */
class Strategy
{
	private $operator = null;

	  
	public function __construct(Operator $operator)
	{
	    $this->operator = $operator;
	}

	public function executeOperate($a, $b)
    {
        return $this->operator->getResult($a, $b);
    }
	
}

/**
 * 运算父类(抽象类或者接口)
 */
abstract class Operator
{

	public abstract function getResult($a, $b);
}

/**
 * 加法运算类
 */
class AddOperator extends Operator
{
	
	function __construct()
	{
		# code...
	}

	public function getResult($a, $b)
	{
		return $a + $b;
	}

}
/**
  *减法运算类
 */
class SubstractOperator extends Operator
{
	
	function __construct()
	{
		# code...
	}

	public function getResult($a, $b)
	{
		return $a - $b;
	}

}
/**
 * 乘法运算类
 */
class MultiplyOperator extends Operator
{
	
	function __construct()
	{
		# code...
	}

	public function getResult($a, $b)
	{
		return $a * $b;
	}

}
/**
 * 处罚运算类
 */
class DevideOperator extends Operator
{
	
	function __construct()
	{
		# code...
	}

	public function getResult($a, $b)
	{
		if ($b != 0) {
			return $a / $b;
		}
		return '除数不能为0';
	}

}

aaa('add',5,2);
aaa('substract',5,2);
aaa('multiply',5,2);
aaa('devide',5,0);
aaa('other',5,0);

function aaa($operator, $a, $b){

    try {

        switch ($operator) {
            case 'add':
                $strategy =   new Strategy(new AddOperator());
                break;
            case 'substract':
                $strategy =   new Strategy(new SubstractOperator());
                break;
            case 'multiply':
                $strategy =   new Strategy(new MultiplyOperator());
                break;
            case 'devide':
                $strategy =   new Strategy(new DevideOperator());
                break;
            default:
                throw new Exception("没有此操作符",1);
                break;
        }
        // 策略 偏重于行为,需要自己执行相应的操作
        $ret = $strategy->executeOperate($a, $b);

    } catch (Exception $e) {
        $ret = $e->getMessage();
    }
    print_r($ret);
}



