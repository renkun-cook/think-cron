<?php
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: huangweijie <1539369355@qq.com>
// +----------------------------------------------------------------------
namespace huangweijie\cron;

use think\App;

abstract class Mode
{
    protected $app;
    protected $think;

    public function __construct()
    {

    }

    public function setApp(App $app)
    {
        $this->app = $app;
        $this->think = $this->app->getRootPath() . 'think';
        return $this;
    }

    abstract public function handle($action);
}