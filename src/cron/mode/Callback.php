<?php
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: huangweijie <1539369355@qq.com>
// +----------------------------------------------------------------------
namespace huangweijie\cron\mode;

class Callback extends \huangweijie\cron\Mode
{
    public function handle($action = '')
    {

        if (!is_array($action)) {
            return;
        }

        foreach ($action as $item) {

            $callback = [];
            $parameter = '';

            if (empty($item) || !is_array($item) || count($item) > 2) {
                continue;
            }

            if (count($item) == 1) {
                $callback = reset($item);
            } else {
                [$callback, $parameter] = array_values($item);
            }

            if (is_string($callback)) {
                if (!strpos($callback, ':')) {
                    continue;
                }

                $callback = explode(':', $callback);
            } else if (!is_array($callback)) {
                continue;
            }

            [$class, $action] = $callback;

            $command = "--class='{$class}' --action='{$action}'";

            if (!empty($parameter)) {
                if (is_array($parameter)) {
                    $parameter = join(',', $parameter);
                }

                $command .= " --argument='{$parameter}'";
            }

            shell_exec("nohup php {$this->think} crontab:callback {$command} >/dev/null 2>&1 &");
        }
    }
}