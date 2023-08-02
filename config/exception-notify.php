<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\LaravelExceptionNotify\Pipes\AppendContentPipe;
use Guanguans\LaravelExceptionNotify\Pipes\FixPrettyJsonPipe;
use Guanguans\LaravelExceptionNotify\Pipes\LengthLimitPipe;
use Guanguans\LaravelExceptionNotify\Pipes\StrReplacePipe;
use Guanguans\LaravelExceptionNotify\Pipes\ToHtmlPipe;
use Guanguans\LaravelExceptionNotify\Pipes\ToMarkdownPipe;

return [
    /**
     * Enable or disable exception notification report.
     */
    'enabled' => (bool) env('EXCEPTION_NOTIFY_ENABLED', true),

    /**
     * The list of environments that should be reported.
     *
     * ```
     * ['production', 'local']
     * ```
     */
    'env' => ['*'],

    /**
     * The list of exception that should not be reported.
     *
     * ```
     * [
     *     HttpResponseException::class,
     *     HttpException::class
     * ]
     * ```
     */
    'dont_report' => [],

    /**
     * The name of queue connection that used to send exception notification.
     */
    'queue_connection' => env('EXCEPTION_NOTIFY_QUEUE_CONNECTION', config('queue.default', 'sync')),

    /**
     * The rate limit of same exception.
     */
    'rate_limit' => [
        'max_attempts' => (int) env('EXCEPTION_NOTIFY_RATE_LIMIT_MAX_ATTEMPTS', config('app.debug') ? 50 : 1),
        'decay_seconds' => (int) env('EXCEPTION_NOTIFY_RATE_LIMIT_DECAY_SECONDS', 300),
    ],

    /**
     * The title of exception notification report.
     */
    'title' => env('EXCEPTION_NOTIFY_TITLE', sprintf('The %s application exception report', config('app.name'))),

    /**
     * The list of collector.
     */
    'collectors' => [
        Guanguans\LaravelExceptionNotify\Collectors\ApplicationCollector::class,
        Guanguans\LaravelExceptionNotify\Collectors\PhpInfoCollector::class,
        Guanguans\LaravelExceptionNotify\Collectors\ChoreCollector::class,
        Guanguans\LaravelExceptionNotify\Collectors\ExceptionBasicCollector::class,
        Guanguans\LaravelExceptionNotify\Collectors\ExceptionPreviewCollector::class,
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

    /**
     * The default channel.
     */
    'default' => env('EXCEPTION_NOTIFY_CHANNEL', 'log'),

    /**
     * The list of channels.
     */
    'channels' => [
        // Bark
        'bark' => [
            'driver' => 'bark',
            'base_uri' => env('EXCEPTION_NOTIFY_BARK_BASE_URI'),
            'token' => env('EXCEPTION_NOTIFY_BARK_TOKEN'),
            'group' => env('EXCEPTION_NOTIFY_BARK_GROUP', config('app.name')),
            'pipes' => [
                sprintf('%s:%s', LengthLimitPipe::class, 1024),
                FixPrettyJsonPipe::class,
            ],
        ],

        // Chanify
        'chanify' => [
            'driver' => 'chanify',
            'base_uri' => env('EXCEPTION_NOTIFY_CHANIFY_BASE_URI'),
            'token' => env('EXCEPTION_NOTIFY_CHANIFY_TOKEN'),
            'pipes' => [
                sprintf('%s:%s', LengthLimitPipe::class, 1024),
                FixPrettyJsonPipe::class,
            ],
        ],

        // 钉钉群机器人
        'dingTalk' => [
            'driver' => 'dingTalk',
            'token' => env('EXCEPTION_NOTIFY_DINGTALK_TOKEN'),
            'secret' => env('EXCEPTION_NOTIFY_DINGTALK_SECRET'),
            'keyword' => env('EXCEPTION_NOTIFY_DINGTALK_KEYWORD'),
            'pipes' => [
                sprintf('%s:%s', LengthLimitPipe::class, 20000),
                FixPrettyJsonPipe::class,
                sprintf('%s:%s', AppendContentPipe::class, env('EXCEPTION_NOTIFY_DINGTALK_KEYWORD')),
            ],
        ],

        // Discord
        'discord' => [
            'driver' => 'discord',
            'webhook_url' => env('EXCEPTION_NOTIFY_DISCORD_WEBHOOK_URL'),
            'pipes' => [
                sprintf('%s:%s', LengthLimitPipe::class, 2000),
                FixPrettyJsonPipe::class,
            ],
        ],

        // 飞书群机器人
        'feiShu' => [
            'driver' => 'feiShu',
            'token' => env('EXCEPTION_NOTIFY_FEISHU_TOKEN'),
            'secret' => env('EXCEPTION_NOTIFY_FEISHU_SECRET'),
            'keyword' => env('EXCEPTION_NOTIFY_FEISHU_KEYWORD'),
            'pipes' => [
                sprintf('%s:%s', LengthLimitPipe::class, 30720),
                FixPrettyJsonPipe::class,
                sprintf('%s:%s', AppendContentPipe::class, env('EXCEPTION_NOTIFY_FEISHU_KEYWORD')),
            ],
        ],

        // Log
        'log' => [
            'driver' => 'log',
            'channel' => env('EXCEPTION_NOTIFY_LOG_CHANNEL', config('logging.default', 'stack')),
            'level' => env('EXCEPTION_NOTIFY_LOG_LEVEL', 'error'),
            'pipes' => [],
        ],

        // 邮件
        // 安装依赖 composer require symfony/mailer -vvv
        'mail' => [
            'driver' => 'mail',
            // smtp://53***11@qq.com:***password***@smtp.qq.com:465?verify_peer=0
            'dsn' => env('EXCEPTION_NOTIFY_MAIL_DSN'),
            'from' => env('EXCEPTION_NOTIFY_MAIL_FROM'),
            'to' => env('EXCEPTION_NOTIFY_MAIL_TO'),
            'pipes' => [
                ToHtmlPipe::class,
            ],
        ],

        // Push Deer
        'pushDeer' => [
            'driver' => 'pushDeer',
            'token' => env('EXCEPTION_NOTIFY_PUSHDEER_TOKEN'),
            'base_uri' => env('EXCEPTION_NOTIFY_PUSHDEER_BASE_URI'),
            'pipes' => [
                ToMarkdownPipe::class,
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
            'pipes' => [
                // 错误码(304003) https://bot.q.qq.com/wiki/develop/api/openapi/error/error.html
                sprintf('%s:%s,%s', StrReplacePipe::class, '.php', '.PHP'),
            ],
        ],

        // Server 酱
        'serverChan' => [
            'driver' => 'serverChan',
            'token' => env('EXCEPTION_NOTIFY_SERVERCHAN_TOKEN'),
            'pipes' => [],
        ],

        // Slack
        'slack' => [
            'driver' => 'slack',
            'webhook_url' => env('EXCEPTION_NOTIFY_SLACK_WEBHOOK_URL'),
            'channel' => env('EXCEPTION_NOTIFY_SLACK_CHANNEL'),
            'pipes' => [
                ToMarkdownPipe::class,
            ],
        ],

        // Telegram
        'telegram' => [
            'driver' => 'telegram',
            'token' => env('EXCEPTION_NOTIFY_TELEGRAM_TOKEN'),
            'chat_id' => env('EXCEPTION_NOTIFY_TELEGRAM_CHAT_ID'),
            'pipes' => [
                sprintf('%s:%s', LengthLimitPipe::class, 4096),
                FixPrettyJsonPipe::class,
            ],
        ],

        // 企业微信群机器人
        'weWork' => [
            'driver' => 'weWork',
            'token' => env('EXCEPTION_NOTIFY_WEWORK_TOKEN'),
            'pipes' => [
                sprintf('%s:%s', LengthLimitPipe::class, 5120),
                FixPrettyJsonPipe::class,
            ],
        ],

        // 息知
        'xiZhi' => [
            'driver' => 'xiZhi',
            'type' => env('EXCEPTION_NOTIFY_XIZHI_TYPE', 'single'), // [single, channel]
            'token' => env('EXCEPTION_NOTIFY_XIZHI_TOKEN'),
            'pipes' => [
                ToMarkdownPipe::class,
            ],
        ],
    ],
];
