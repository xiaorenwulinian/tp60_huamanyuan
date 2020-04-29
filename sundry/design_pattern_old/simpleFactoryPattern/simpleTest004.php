<?php
/**
 * 以计算器为例
 */


/**
 * 操作符号工厂类 
 */
class OperatorFactory 
{
	
	function __construct()
	{
		# code...
	}

	public static function createOperator($operator)
	{
		switch ($operator) {
			case 'add':
				$oper = new AddOperator();
				break;
		    case 'substract':
		    	$oper = new SubstractOperator();
		    	break;
			case 'multiply':
				$oper = new MultiplyOperator();
				break;
			case 'devide':
				$oper = new DevideOperator();
				break;
			default:
				throw new Exception("没有此操作符",1);
				break;	
		}	
		return $oper;
	}

	
}

/**
 * 运算父类
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
function aaa($operate, $a, $b){

	try {
        $oper = OperatorFactory::createOperator($operate);
        $ret =  $oper->getResult($a, $b);
	} catch (Exception $e) {
		$ret = $e->getMessage();
	}
	print_r($ret);
}

