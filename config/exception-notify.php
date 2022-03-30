<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\LaravelExceptionNotify\Pipelines\AppendContentPipeline;
use Guanguans\LaravelExceptionNotify\Pipelines\LengthLimitPipeline;
use Guanguans\LaravelExceptionNotify\Pipelines\StrReplacePipeline;
use Guanguans\LaravelExceptionNotify\Pipelines\ToHtmlPipeline;
use Guanguans\LaravelExceptionNotify\Pipelines\ToMarkdownPipeline;
use Guanguans\LaravelExceptionNotify\Pipelines\TrimPipeline;

return [
    /*
    |--------------------------------------------------------------------------
    | Enable exception notification report switch.
    |--------------------------------------------------------------------------
    |
    | If set to false, the exception notification report will not be enabled.
    |
    */
    'enabled' => (bool) env('EXCEPTION_NOTIFY_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | A list of the application environments that are reported.
    |--------------------------------------------------------------------------
    |
    | Here you may specify a list of the application environments that should
    | be reported.
    |
    | ```
    | [production, local]
    | ```
    */
    'env' => ['*'],

    /*
    |--------------------------------------------------------------------------
    | A list of the exception types that are not reported.
    |--------------------------------------------------------------------------
    |
    | Here you may specify a list of the exception types that should not be
    | reported.
    |
    | ```
    | [
    |     HttpResponseException::class,
    |     HttpException::class,
    | ]
    | ```
    */
    'dont_report' => [],

    /*
    |--------------------------------------------------------------------------
    | Report title.
    |--------------------------------------------------------------------------
    |
    | The title of the exception notification report.
    |
    */
    'title' => env('EXCEPTION_NOTIFY_REPORT_TITLE', sprintf('%s application exception report.', config('app.name'))),

    /*
    |--------------------------------------------------------------------------
    | Collector configuration.
    |--------------------------------------------------------------------------
    |
    | Responsible for collecting and transforming the exception data.
    |
    */
    'collector' => [
        // List of collectors
        'class' => [
            \Guanguans\LaravelExceptionNotify\Collectors\LaravelCollector::class,
            \Guanguans\LaravelExceptionNotify\Collectors\AnnexCollector::class,
            \Guanguans\LaravelExceptionNotify\Collectors\PhpInfoCollector::class,
            \Guanguans\LaravelExceptionNotify\Collectors\ExceptionBasicCollector::class,
            \Guanguans\LaravelExceptionNotify\Collectors\ExceptionTraceCollector::class,
            \Guanguans\LaravelExceptionNotify\Collectors\RequestBasicCollector::class,
            \Guanguans\LaravelExceptionNotify\Collectors\RequestHeaderCollector::class,
            \Guanguans\LaravelExceptionNotify\Collectors\RequestQueryCollector::class,
            \Guanguans\LaravelExceptionNotify\Collectors\RequestPostCollector::class,
            \Guanguans\LaravelExceptionNotify\Collectors\RequestFileCollector::class,
            // \Guanguans\LaravelExceptionNotify\Collectors\RequestMiddlewareCollector::class,
            // \Guanguans\LaravelExceptionNotify\Collectors\RequestServerCollector::class,
            // \Guanguans\LaravelExceptionNotify\Collectors\RequestCookieCollector::class,
            // \Guanguans\LaravelExceptionNotify\Collectors\RequestSessionCollector::class,
        ],
        // The transformer is used to transformer collectors to reports.
        'transformer' => \Guanguans\LaravelExceptionNotify\CollectorTransformer::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Reporting event.
    |--------------------------------------------------------------------------
    |
    | The event that will be triggered when the report is ready.
    |
    */
    'reporting' => [
        // \Guanguans\LaravelExceptionNotify\Listeners\Reporting\LogReportListener::class,
        // \Guanguans\LaravelExceptionNotify\Listeners\Reporting\DumpReportListener::class,
        // \Guanguans\LaravelExceptionNotify\Listeners\Reporting\DdReportListener::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Reported event.
    |--------------------------------------------------------------------------
    |
    | The event that will be triggered when the report is reported.
    |
    */
    'reported' => [
        // \Guanguans\LaravelExceptionNotify\Listeners\Reported\LogReportResultListener::class,
        // \Guanguans\LaravelExceptionNotify\Listeners\Reported\DumpReportResultListener::class,
        // \Guanguans\LaravelExceptionNotify\Listeners\Reported\DdReportResultListener::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Global pipeline.
    |--------------------------------------------------------------------------
    | The global pipeline are used to pipeline report data.
    |
    */
    'pipeline' => [
        TrimPipeline::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | default channel.
    |--------------------------------------------------------------------------
    |
    | The default channel of the exception notification report.
    |
    */
    'default' => env('EXCEPTION_NOTIFY_DEFAULT_CHANNEL', 'log'),

    /*
    |--------------------------------------------------------------------------
    | Supported channels.
    |--------------------------------------------------------------------------
    |
    | Here you may specify a list of the supported channels.
    |
    */
    'channels' => [
        // Bark
        'bark' => [
            'driver' => 'bark',
            'base_uri' => env('EXCEPTION_NOTIFY_BARK_BASE_URI'),
            'token' => env('EXCEPTION_NOTIFY_BARK_TOKEN'),
            'group' => env('EXCEPTION_NOTIFY_BARK_GROUP', config('app.name')),
            'pipeline' => [
                sprintf('%s:%s', LengthLimitPipeline::class, 1024),
            ],
        ],

        // Chanify
        'chanify' => [
            'driver' => 'chanify',
            'base_uri' => env('EXCEPTION_NOTIFY_CHANIFY_BASE_URI'),
            'token' => env('EXCEPTION_NOTIFY_CHANIFY_TOKEN'),
            'pipeline' => [
                sprintf('%s:%s', LengthLimitPipeline::class, 1024),
            ],
        ],

        // 钉钉群机器人
        'dingTalk' => [
            'driver' => 'dingTalk',
            'token' => env('EXCEPTION_NOTIFY_DINGTALK_TOKEN'),
            'secret' => env('EXCEPTION_NOTIFY_DINGTALK_SECRET'),
            'keyword' => env('EXCEPTION_NOTIFY_DINGTALK_KEYWORD'),
            'pipeline' => [
                sprintf('%s:%s', LengthLimitPipeline::class, 20000),
                sprintf('%s:%s', AppendContentPipeline::class, env('EXCEPTION_NOTIFY_DINGTALK_KEYWORD')),
            ],
        ],

        // Discord
        'discord' => [
            'driver' => 'discord',
            'webhook_url' => env('EXCEPTION_NOTIFY_DISCORD_WEBHOOK_URL'),
            'pipeline' => [
                sprintf('%s:%s', LengthLimitPipeline::class, 2000),
            ],
        ],

        // 飞书群机器人
        'feiShu' => [
            'driver' => 'feiShu',
            'token' => env('EXCEPTION_NOTIFY_FEISHU_TOKEN'),
            'secret' => env('EXCEPTION_NOTIFY_FEISHU_SECRET'),
            'keyword' => env('EXCEPTION_NOTIFY_FEISHU_KEYWORD'),
            'pipeline' => [
                sprintf('%s:%s', LengthLimitPipeline::class, 30720),
                sprintf('%s:%s', AppendContentPipeline::class, env('EXCEPTION_NOTIFY_FEISHU_KEYWORD')),
            ],
        ],

        // Log
        'log' => [
            'driver' => 'log',
            'channel' => env('EXCEPTION_NOTIFY_LOG_CHANNEL', config('logging.default', 'stack')),
            'level' => env('EXCEPTION_NOTIFY_LOG_LEVEL', 'error'),
            'pipeline' => [],
        ],

        // 邮件
        'mail' => [
            'driver' => 'mail',
            'dsn' => env('EXCEPTION_NOTIFY_MAIL_DSN'),
            'from' => env('EXCEPTION_NOTIFY_MAIL_FROM'),
            'to' => env('EXCEPTION_NOTIFY_MAIL_TO'),
            'pipeline' => [
                ToHtmlPipeline::class,
            ],
        ],

        // Push Deer
        'pushDeer' => [
            'driver' => 'pushDeer',
            'token' => env('EXCEPTION_NOTIFY_PUSHDEER_TOKEN'),
            'base_uri' => env('EXCEPTION_NOTIFY_PUSHDEER_BASE_URI'),
            'pipeline' => [
                ToMarkdownPipeline::class,
            ],
        ],

        // QQ Channel Bot
        'qqChannelBot' => [
            'driver' => 'qqChannelBot',
            'appid' => env('EXCEPTION_NOTIFY_QQCHANNELBOT_APPID'),
            'token' => env('EXCEPTION_NOTIFY_QQCHANNELBOT_TOKEN'),
            'channel_id' => env('EXCEPTION_NOTIFY_QQCHANNELBOT_CHANNEL_ID'),
            'environment' => env('EXCEPTION_NOTIFY_QQCHANNELBOT_ENVIRONMENT', 'production'),
            'pipeline' => [
                // 错误码(304003) https://bot.q.qq.com/wiki/develop/api/openapi/error/error.html
                sprintf('%s:%s,%s', StrReplacePipeline::class, '.php', '.PHP'),
            ],
        ],

        // Server 酱
        'serverChan' => [
            'driver' => 'serverChan',
            'token' => env('EXCEPTION_NOTIFY_SERVERCHAN_TOKEN'),
            'pipeline' => [],
        ],

        // Slack
        'slack' => [
            'driver' => 'slack',
            'webhook_url' => env('EXCEPTION_NOTIFY_SLACK_WEBHOOK_URL'),
            'channel' => env('EXCEPTION_NOTIFY_SLACK_CHANNEL'),
            'pipeline' => [
                ToMarkdownPipeline::class,
            ],
        ],

        // Telegram
        'telegram' => [
            'driver' => 'telegram',
            'token' => env('EXCEPTION_NOTIFY_TELEGRAM_TOKEN'),
            'chat_id' => env('EXCEPTION_NOTIFY_TELEGRAM_CHAT_ID'),
            'pipeline' => [
                sprintf('%s:%s', LengthLimitPipeline::class, 4096),
            ],
        ],

        // 企业微信群机器人
        'weWork' => [
            'driver' => 'weWork',
            'token' => env('EXCEPTION_NOTIFY_WEWORK_TOKEN'),
            'pipeline' => [
                sprintf('%s:%s', LengthLimitPipeline::class, 5120),
            ],
        ],

        // 息知
        'xiZhi' => [
            'driver' => 'xiZhi',
            'type' => env('EXCEPTION_NOTIFY_XIZHI_TYPE', 'single'), // [single, channel]
            'token' => env('EXCEPTION_NOTIFY_XIZHI_TOKEN'),
            'pipeline' => [
                ToMarkdownPipeline::class,
            ],
        ],
    ],
];
