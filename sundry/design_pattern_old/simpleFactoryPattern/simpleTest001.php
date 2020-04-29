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
		switch ($operate) {
			case 'add':
				$ret = $this->add($a, $b);
				break;
		    case 'substract':
		    	$ret = $this->substract($a, $b);
		    	break;
			case 'multiply':
				$ret = $this->multiply($a, $b);
				break;
			case 'devide':
				$ret = $this->devide($a, $b);
				break;
			default:
				$ret = '没有此操作符';
				break;	
		}	
		return $ret;
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
function aaa($operate, $a, $b) 
{

	$cal = new Calculator();
	$ret = $cal->getResult($operate,$a,$b);
	print_r($ret);
}


