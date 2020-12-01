<?php
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: huangweijie <1539369355@qq.com>
// +----------------------------------------------------------------------
namespace huangweijie\cron\mode;

class Command extends \huangweijie\cron\Mode
{
    public function handle($action)
    {

       is_string($action) && $action = [$action];

       if (!is_array($action)) {
           return;
       }

       foreach ($action as $commandLine) {

           if (empty($commandLine) || !is_string($commandLine)) {
               continue;
           }

           shell_exec("nohup php {$this->think} {$commandLine} >/dev/null 2>&1 &");
       }
    }
}