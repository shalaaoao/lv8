<?php


return [
    'robot_base_url' => env('DING_ROBOT_URL', 'https://oapi.dingtalk.com/robot/send'),
    'timeout'        => 2.0,
    'access_token'   => [
        'default' => env('DING_TOKEN', '你的钉钉群组机器人token'),// 默认
        'others'  => [ // 扩展更多token
            'xxx' => env('XXX_TOKEN', '你的钉钉群组机器人token'),
            'zhu' => '745532d0616221f2e3520b1f7c2ac89a308f51f9bc13936ef68e831a4e1c1fa6',
        ],
    ],
];
