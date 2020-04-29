<?php
/**
 * 以计算器为例
 */
class Calculator
{
	
	public function __construct()
	{
		
	}


	/**
	 * 计算结果
	 $operate String 操作符号
	 $a int 数字a
	 $b int 数字a
	 */
	
	public function getResult($operate,$a,$b)
	{
		$methors = [
			'add','substract','multiply','devide'
		];
		if (! in_array($operate, $methors)) {
			return '没有此操作符';
		}
		return call_user_func_array([self::class,$operate], [$a,$b]);
	}

	public function add($a, $b)
	{
		return $a + $b;
	}

	public function substract($a, $b)
	{
		return $a - $b;
	}

	public function multiply($a, $b)
	{
		return $a * $b;
	}

	public function devide($a, $b)
	{
		if ($b != 0) {
			return $a / $b;
		}
		return '除数不能为0';
	}


}

aaa('add',5,2);
// aaa('substract',5,2);
// aaa('multiply',5,2);
// aaa('devide',5,0);
// aaa('other',5,0);
function aaa($operate, $a, $b){

	$cal = new Calculator();
	$ret = $cal->getResult($operate,$a,$b);
	print_r($ret);
}

