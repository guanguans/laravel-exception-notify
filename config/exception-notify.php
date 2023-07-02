<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\LaravelExceptionNotify\Sanitizers\AppendContentSanitizer;
use Guanguans\LaravelExceptionNotify\Sanitizers\FixPrettyJsonSanitizer;
use Guanguans\LaravelExceptionNotify\Sanitizers\LengthLimitSanitizer;
use Guanguans\LaravelExceptionNotify\Sanitizers\StrReplaceSanitizer;
use Guanguans\LaravelExceptionNotify\Sanitizers\ToHtmlSanitizer;
use Guanguans\LaravelExceptionNotify\Sanitizers\ToMarkdownSanitizer;

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
    | Connection of queue.
    |--------------------------------------------------------------------------
    */
    'queue_connection' => env('EXCEPTION_NOTIFY_QUEUE_CONNECTION', config('queue.default', 'sync')),

    /*
    |--------------------------------------------------------------------------
    | Exception notification rate limiter.
    |--------------------------------------------------------------------------
    |
    | The exception notification rate limiter is used to prevent sending
    | exception notification to the same channel too frequently.
    |
    */
    'rate_limiter' => [
        'max_attempts' => (int) env('EXCEPTION_NOTIFY_LIMIT', config('app.debug') ? 50 : 1),
        'decay_seconds' => 300,
    ],

    /*
    |--------------------------------------------------------------------------
    | Report title.
    |--------------------------------------------------------------------------
    |
    | The title of the exception notification report.
    |
    */
    'title' => env('EXCEPTION_NOTIFY_REPORT_TITLE', sprintf('%s application exception report', config('app.name'))),

    /*
    |--------------------------------------------------------------------------
    | List of collectors.
    |--------------------------------------------------------------------------
    |
    | Responsible for collecting the exception data.
    |
    */
    'collector' => [
        Guanguans\LaravelExceptionNotify\Collectors\ApplicationCollector::class,
        Guanguans\LaravelExceptionNotify\Collectors\ChoreCollector::class,
        Guanguans\LaravelExceptionNotify\Collectors\PhpInfoCollector::class,
        Guanguans\LaravelExceptionNotify\Collectors\ExceptionBasicCollector::class,
        Guanguans\LaravelExceptionNotify\Collectors\ExceptionTraceCollector::class,
        Guanguans\LaravelExceptionNotify\Collectors\RequestBasicCollector::class,
        Guanguans\LaravelExceptionNotify\Collectors\RequestHeaderCollector::class,
        Guanguans\LaravelExceptionNotify\Collectors\RequestQueryCollector::class,
        Guanguans\LaravelExceptionNotify\Collectors\RequestPostCollector::class,
        Guanguans\LaravelExceptionNotify\Collectors\RequestFileCollector::class,
        // \Guanguans\LaravelExceptionNotify\Collectors\RequestMiddlewareCollector::class,
        // \Guanguans\LaravelExceptionNotify\Collectors\RequestServerCollector::class,
        // \Guanguans\LaravelExceptionNotify\Collectors\RequestCookieCollector::class,
        // \Guanguans\LaravelExceptionNotify\Collectors\RequestSessionCollector::class,
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
            'sanitizers' => [
                sprintf('%s:%s', LengthLimitSanitizer::class, 1024),
                FixPrettyJsonSanitizer::class,
            ],
        ],

        // Chanify
        'chanify' => [
            'driver' => 'chanify',
            'base_uri' => env('EXCEPTION_NOTIFY_CHANIFY_BASE_URI'),
            'token' => env('EXCEPTION_NOTIFY_CHANIFY_TOKEN'),
            'sanitizers' => [
                sprintf('%s:%s', LengthLimitSanitizer::class, 1024),
                FixPrettyJsonSanitizer::class,
            ],
        ],

        // 钉钉群机器人
        'dingTalk' => [
            'driver' => 'dingTalk',
            'token' => env('EXCEPTION_NOTIFY_DINGTALK_TOKEN'),
            'secret' => env('EXCEPTION_NOTIFY_DINGTALK_SECRET'),
            'keyword' => env('EXCEPTION_NOTIFY_DINGTALK_KEYWORD'),
            'sanitizers' => [
                sprintf('%s:%s', LengthLimitSanitizer::class, 20000),
                FixPrettyJsonSanitizer::class,
                sprintf('%s:%s', AppendContentSanitizer::class, env('EXCEPTION_NOTIFY_DINGTALK_KEYWORD')),
            ],
        ],

        // Discord
        'discord' => [
            'driver' => 'discord',
            'webhook_url' => env('EXCEPTION_NOTIFY_DISCORD_WEBHOOK_URL'),
            'sanitizers' => [
                sprintf('%s:%s', LengthLimitSanitizer::class, 2000),
                FixPrettyJsonSanitizer::class,
            ],
        ],

        // 飞书群机器人
        'feiShu' => [
            'driver' => 'feiShu',
            'token' => env('EXCEPTION_NOTIFY_FEISHU_TOKEN'),
            'secret' => env('EXCEPTION_NOTIFY_FEISHU_SECRET'),
            'keyword' => env('EXCEPTION_NOTIFY_FEISHU_KEYWORD'),
            'sanitizers' => [
                sprintf('%s:%s', LengthLimitSanitizer::class, 30720),
                FixPrettyJsonSanitizer::class,
                sprintf('%s:%s', AppendContentSanitizer::class, env('EXCEPTION_NOTIFY_FEISHU_KEYWORD')),
            ],
        ],

        // Log
        'log' => [
            'driver' => 'log',
            'channel' => env('EXCEPTION_NOTIFY_LOG_CHANNEL', config('logging.default', 'stack')),
            'level' => env('EXCEPTION_NOTIFY_LOG_LEVEL', 'error'),
            'sanitizers' => [],
        ],

        // 邮件
        // 安装依赖 composer require symfony/mailer -vvv
        'mail' => [
            'driver' => 'mail',
            // smtp://53***11@qq.com:***password***@smtp.qq.com:465?verify_peer=0
            'dsn' => env('EXCEPTION_NOTIFY_MAIL_DSN'),
            'from' => env('EXCEPTION_NOTIFY_MAIL_FROM'),
            'to' => env('EXCEPTION_NOTIFY_MAIL_TO'),
            'sanitizers' => [
                ToHtmlSanitizer::class,
            ],
        ],

        // Push Deer
        'pushDeer' => [
            'driver' => 'pushDeer',
            'token' => env('EXCEPTION_NOTIFY_PUSHDEER_TOKEN'),
            'base_uri' => env('EXCEPTION_NOTIFY_PUSHDEER_BASE_URI'),
            'sanitizers' => [
                ToMarkdownSanitizer::class,
            ],
        ],

        // QQ Channel Bot
        // 安装依赖 composer require textalk/websocket -vvv
        'qqChannelBot' => [
            'driver' => 'qqChannelBot',
            'appid' => env('EXCEPTION_NOTIFY_QQCHANNELBOT_APPID'),
            'token' => env('EXCEPTION_NOTIFY_QQCHANNELBOT_TOKEN'),
            'channel_id' => env('EXCEPTION_NOTIFY_QQCHANNELBOT_CHANNEL_ID'),
            'environment' => env('EXCEPTION_NOTIFY_QQCHANNELBOT_ENVIRONMENT', 'production'),
            'sanitizers' => [
                // 错误码(304003) https://bot.q.qq.com/wiki/develop/api/openapi/error/error.html
                sprintf('%s:%s,%s', StrReplaceSanitizer::class, '.php', '.PHP'),
            ],
        ],

        // Server 酱
        'serverChan' => [
            'driver' => 'serverChan',
            'token' => env('EXCEPTION_NOTIFY_SERVERCHAN_TOKEN'),
            'sanitizers' => [],
        ],

        // Slack
        'slack' => [
            'driver' => 'slack',
            'webhook_url' => env('EXCEPTION_NOTIFY_SLACK_WEBHOOK_URL'),
            'channel' => env('EXCEPTION_NOTIFY_SLACK_CHANNEL'),
            'sanitizers' => [
                ToMarkdownSanitizer::class,
            ],
        ],

        // Telegram
        'telegram' => [
            'driver' => 'telegram',
            'token' => env('EXCEPTION_NOTIFY_TELEGRAM_TOKEN'),
            'chat_id' => env('EXCEPTION_NOTIFY_TELEGRAM_CHAT_ID'),
            'sanitizers' => [
                sprintf('%s:%s', LengthLimitSanitizer::class, 4096),
                FixPrettyJsonSanitizer::class,
            ],
        ],

        // 企业微信群机器人
        'weWork' => [
            'driver' => 'weWork',
            'token' => env('EXCEPTION_NOTIFY_WEWORK_TOKEN'),
            'sanitizers' => [
                sprintf('%s:%s', LengthLimitSanitizer::class, 5120),
                FixPrettyJsonSanitizer::class,
            ],
        ],

        // 息知
        'xiZhi' => [
            'driver' => 'xiZhi',
            'type' => env('EXCEPTION_NOTIFY_XIZHI_TYPE', 'single'), // [single, channel]
            'token' => env('EXCEPTION_NOTIFY_XIZHI_TOKEN'),
            'sanitizers' => [
                ToMarkdownSanitizer::class,
            ],
        ],
    ],
];
