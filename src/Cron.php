<?php
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: huangweijie <1539369355@qq.com>
// +----------------------------------------------------------------------
namespace huangweijie;

use InvalidArgumentException;
use XCron\CronExpression;
use think\helper\Str;
use think\Factory;
use think\App;

class Cron extends Factory
{
    protected $namespace = '\\huangweijie\\cron\\mode\\';
    private $tasks = [];

    public function __construct(App $app)
    {
        parent::__construct($app);

        $tasks = $this->app->config->get('crontab.tasks', []);
        $this->tasks = $this->schedule($tasks);
    }

    public function getTasks()
    {
        return $this->tasks;
    }

    protected function createDriver($name = '')
    {
        $driver = empty($name)? $this->getDefaultDriver(): $name;

        $class = false !== strpos($driver, '\\') ? $driver : $this->namespace . Str::studly($driver);

        /** @var Connector $driver */
        if (class_exists($class)) {
            $driver = $this->app->invokeClass($class);

            return $driver->setApp($this->app);
        }

        throw new InvalidArgumentException("Driver [$driver] not supported.");
    }

    /**
     * @param null $name
     * @return mixed
     */
    public function mode($name = null)
    {
        return $this->driver($name);
    }

    /**
     * 默认驱动
     * @return string
     */
    public function getDefaultDriver()
    {
        return 'callback';
    }

    /**
     * 获取可执行任务列表
     * @param array $tasks
     * @return array
     */
    public function schedule(Array $tasks)
    {
        $taskList = [];
        foreach ($tasks as $task) {
            try {
                $cron = CronExpression::factory($task['time']);
                if ($cron->isDue()) {
                    $taskList[] = $task;
                }
            } catch (\Exception $e) {
                echo $e->getMessage();
                throw new \Exception("定时器异常");
            }
        }

        return $taskList;
    }
}