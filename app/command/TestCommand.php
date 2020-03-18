<?php
declare (strict_types = 1);

namespace app\command;

use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;

class TestCommand extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('test:abc')
            ->addArgument('date', Argument::OPTIONAL,'date of use ')
            ->addOption('type','t',Option::VALUE_REQUIRED,'type sex',1)
            ->setDescription('the test command');
    }

    protected function execute(Input $input, Output $output)
    {
        cache('name','lcl', 60);
        $date = $input->getArgument('date');
        $type = $input->getOption('type');
        $date = $date ?? date('Y-m-d');
    	// 指令输出
        echo 4;
    	$output->writeln('test_date:' . $date . " {$type}");
    }


}
