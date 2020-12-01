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
use huangweijie\Cron;
use think\facade\Db;

class Handle extends Command
{
    protected $cron;
    protected $able = true;

    public function __construct(Cron $cron)
    {
        parent::__construct();
        $this->cron = $cron;
    }

    protected function configure()
    {
        $this->setName('crontab:handle')->setDescription('crontab handle');
    }

    protected function initialize(Input $input, Output $output)
    {
        if (strtoupper(PHP_OS ) == 'LINUX') {
            return;
        }

        $this->able = false;
        $this->output->writeln('[Warning]:Windows is not supported');
    }

    protected function execute(Input $input, Output $output)
    {
        if (!$this->able) {
            return;
        }

        $tasks = $this->cron->getTasks();

        $data = Db::name("cron_task")->where('status',1)->where('deleted_at',0)->select()->toArray();

        $temp_arr = [];
        foreach ($data as $key => $val){
            $temp_arr[$key]['time'] = $val['task_time'];
            $temp_arr[$key]['mode']['callback'][][0] = $val['task_name'];
            if(!empty($val["params"])){
                $temp_arr[$key]['mode']['callback'][][1] = $val["params"];
            }
            array_push($tasks,$temp_arr);
        }

        foreach ($tasks as $task) {
            if (empty($task['mode']) || !is_array($task['mode'])) {
                continue;
            }

            foreach ($task['mode'] as $modeName => $action) {

                if (is_numeric($modeName) || !in_array($modeName, ['command', 'callback']) || empty($action)) {
                    continue;
                }


                $this->cron->mode($modeName)->handle($action);
            }

        }
    }
}