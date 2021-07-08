<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

return [
    /*
     * Enable exception notification report switch.
     */
    'enabled' => (bool) env('EXCEPTION_NOTIFY_ENABLED', true),

    /*
     * A list of the application environments that are reported.
     *
     * ```
     * [production, local]
     * ```
     */
    'env' => ['*'],

    /*
     * A list of the exception types that are not reported.
     *
     * ```
     * [
     *      HttpException::class,
     *      HttpResponseException::class,
     * ]
     * ```
     */
    'dontReport' => [],

    /*
     * Debug mode.
     */
    'debug' => (bool) env('EXCEPTION_NOTIFY_DEBUG', false),

    /*
     * Information collector.
     */
    'collector' => [
        'app_name' => true,
        'app_env' => true,
        'trigger_time' => true,
        'request_method' => true,
        'request_url' => true,
        'request_ip' => true,
        'request_data' => true,
        'exception_stack_trace' => true,
    ],

    /*
     * Default channel.
     */
    'defaultChannel' => env('EXCEPTION_NOTIFY_DEFAULT_CHANNEL', 'dingTalk'),

    /*
     * Supported channels
     */
    'channels' => [
        // 钉钉群机器人
        'dingTalk' => [
            'keyword' => env('EXCEPTION_NOTIFY_CHANNEL_KEYWORD', 'Your keyword.'),
            'token' => env('EXCEPTION_NOTIFY_CHANNEL_TOKEN', 'Your token.'),
            'secret' => env('EXCEPTION_NOTIFY_CHANNEL_SECRET', 'Your secret.'),
        ],

        // 飞书群机器人
        'feiShu' => [
            'keyword' => env('EXCEPTION_NOTIFY_CHANNEL_KEYWORD', 'Your keyword.'),
            'token' => env('EXCEPTION_NOTIFY_CHANNEL_TOKEN', 'Your token.'),
            'secret' => env('EXCEPTION_NOTIFY_CHANNEL_SECRET', 'Your secret.'),
        ],

        // Server 酱
        'serverChan' => [
            'token' => env('EXCEPTION_NOTIFY_CHANNEL_TOKEN', 'Your token.'),
        ],

        // 企业微信群机器人
        'weWork' => [
            'token' => env('EXCEPTION_NOTIFY_CHANNEL_TOKEN', 'Your token.'),
        ],

        // 息知
        'xiZhi' => [
            'type' => 'single', // [single, channel]
            'token' => env('EXCEPTION_NOTIFY_CHANNEL_TOKEN', 'Your token.'),
        ],
    ],
];
