<?php
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: huangweijie <1539369355@qq.com>
// +----------------------------------------------------------------------
return [
    'tasks' => [
        [
            'time' => '0 10,50 */3 * * *',
            'mode' => [
                'command' => ['test', 'think-queue-manage:handle'],
                'callback' => [
                    ["app\admin\controller\JobTest:test1"],
                    [['app\admin\controller\JobTest','test1']],
                    ["app\admin\controller\JobTest:test1", 'huangweijie,huangweijie2'],
                    ["app\admin\controller\JobTest:test1", ['huangweijie,huangweijie2']],
                    [['app\admin\controller\JobTest','test1'], ['huangweijie,huangweijie2']]
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
                    ["app\admin\controller\JobTest:test1", 'huangweijie']
                ]
            ]
        ],
    ]
];