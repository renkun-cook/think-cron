<?php
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: huangweijie <1539369355@qq.com>
// +----------------------------------------------------------------------
namespace huangweijie\cron;

use huangweijie\Cron;
use huangweijie\cron\command\Handle;
use huangweijie\cron\command\CallbackHandle;

class Service extends \think\Service
{
    public function register()
    {
        $this->app->bind(Cron::class);
    }

    public function boot()
    {
        $this->commands([
            Handle::class,
            CallbackHandle::class
        ]);
    }
}