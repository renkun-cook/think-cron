# think-cron 计划任务

#### 介绍
一个基于thinkphp的通用crontab

#### 安装教程

```shell
composer require renkun-cook/think-cron
```

#### 使用说明
请参考CronExpression表达式

配置

```
项目根目录/config/crontab.php
<?php

return [
    'tasks' => [
        [
            'time' => '0 10,50 */3 * * *',
            'mode' => [
                'command' => ['test', 'think-queue-manage:handle'],
                'callback' => [
                    ["app\admin\controller\JobTest:test1"],
                    [['app\admin\controller\JobTest','test1']], 
                    ["app\admin\controller\JobTest:test1", 'renkun-cook,renkun-cook2'],
                    ["app\admin\controller\JobTest:test1", ['renkun-cook,renkun-cook2']], 
                    [['app\admin\controller\JobTest','test1'], ['renkun-cook,renkun-cook2']] 
                ]
            ]
        ],
        [
            'time' => '* * * * * *',
            'mode' => [
                'command' => ['think-queue-manage:handle']
            ]
        ],
        [
            'time' => '0 2,9,36 */2 * * *',
            'mode' => [
                'callback' => [
                    ["app\admin\controller\JobTest:test1", 'renkun-cook']
                ]
            ]
        ],
    ]
];
```

在系统的计划任务里添加
~~~
* * * * * php /path/to/think crontab:handle >> /dev/null 2>&1
~~~
注意：linux系统的crontab 不支持秒级定时,CronExpression表达式的秒部分填0

