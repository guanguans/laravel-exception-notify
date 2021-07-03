<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

return [
    'default' => env('EXCEPTION_NOTIFY_CHANNEL', 'dingTalk'),

    'debug' => false,

    'collector' => [
        'trigger_time' => true,
        'request_url' => true,
        'request_ip' => true,
        'request_method' => true,
        'request_data' => true,
        'exception_trace' => true,
    ],

    'channels' => [
        // 钉钉群机器人
        'dingTalk' => [
            'keyword' => 'keyword',
            'token' => 'c44fec1ddaa8a833156efb77b7865d62ae13775418030d94d05da08bfca73eeb',
            'secret' => 'SECc32bb7345c0f73da2b9786f0f7dd5083bd768a29b82e6d460149d730eee51730',
        ],

        // 飞书群机器人
        'feiShu' => [
            'keyword' => 'keyword',
            'token' => 'b6eb70d9-6e19-4f87-af48-348b0281866c',
            'secret' => 'iigDOvnsIn6aFS1pYHHEHh',
        ],

        // Server 酱
        'serverChan' => [
            'token' => 'SCT35149Thtf1g2Bc14QJuQ6HFpW5YGXm',
        ],

        // 企业微信群机器人
        'weWork' => [
            'token' => '73a3d5a3-ceff-4da8-bcf3-ff5891778fb7',
        ],

        // 息知
        'xiZhi' => [
            'type' => 'single', // [single, channel]
            'token' => 'XZd60aea56567ae39a1b1920cbc42bb5bd',
        ],
    ],
];
