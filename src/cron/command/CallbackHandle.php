<?php
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: huangweijie <1539369355@qq.com>
// +----------------------------------------------------------------------
namespace huangweijie\cron\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\console\input\Option;

class CallbackHandle extends Command
{
    protected $able = true;

    protected function configure()
    {
        $this->setName('crontab:callback')
            ->addOption('class', null, Option::VALUE_REQUIRED, 'class')
            ->addOption('action', null, Option::VALUE_REQUIRED, 'action')
            ->addOption('argument', null, Option::VALUE_OPTIONAL, 'argument')
            ->setDescription('callback handle');
    }

    protected function initialize(Input $input, Output $output)
    {
        if (strtoupper(PHP_OS ) == 'LINUX') {
            return;
        }

        $this->able = false;
    }

    protected function execute(Input $input, Output $output)
    {

        $calss = $input->getOption('class');

        $action = $input->getOption('action');

        $argument = $input->getOption('argument');

        if (!$this->able || empty($calss) || empty($action) || !is_callable([$calss, $action])) {
            return;
        }

        $argument = empty($argument)? []: explode(',', $argument);
        $this->app->invokeMethod([$calss, $action], $argument);
    }
}