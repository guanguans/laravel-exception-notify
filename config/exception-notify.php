<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\LaravelExceptionNotify\Pipes\AddKeywordPipe;
use Guanguans\LaravelExceptionNotify\Pipes\FixPrettyJsonPipe;
use Guanguans\LaravelExceptionNotify\Pipes\LimitLengthPipe;
use Guanguans\LaravelExceptionNotify\Pipes\ReplaceStrPipe;
use Guanguans\LaravelExceptionNotify\Pipes\ToHtmlPipe;
use Guanguans\LaravelExceptionNotify\Pipes\ToMarkdownPipe;

return [
    /**
     * Enable or disable exception notification report.
     */
    'enabled' => (bool) env('EXCEPTION_NOTIFY_ENABLED', true),

    /**
     * The list of environments that should be reported.
     */
    'env' => env_explode('EXCEPTION_NOTIFY_ENV', [
        // 'production',
        // 'local',
        // 'testing',
        '*',
    ]),

    /**
     * The list of exception that should not be reported.
     */
    'except' => [
        // Symfony\Component\HttpKernel\Exception\HttpException::class,
        // Illuminate\Http\Exceptions\HttpResponseException::class,
    ],

    /**
     * The options of report exception job.
     */
    'job' => [
        'connection' => env('EXCEPTION_NOTIFY_JOB_CONNECTION', config('queue.default', 'sync')),
        'queue' => env('EXCEPTION_NOTIFY_JOB_QUEUE'),
    ],

    /**
     * The rate limit of same exception.
     */
    'rate_limit' => [
        'key_prefix' => env('EXCEPTION_NOTIFY_RATE_LIMIT_KEY_PREFIX', 'exception-notify-'),
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
        Guanguans\LaravelExceptionNotify\Collectors\ExceptionContextCollector::class,
        Guanguans\LaravelExceptionNotify\Collectors\ExceptionTraceCollector::class,
        Guanguans\LaravelExceptionNotify\Collectors\RequestBasicCollector::class,
        Guanguans\LaravelExceptionNotify\Collectors\RequestHeaderCollector::class,
        Guanguans\LaravelExceptionNotify\Collectors\RequestQueryCollector::class,
        Guanguans\LaravelExceptionNotify\Collectors\RequestPostCollector::class,
        Guanguans\LaravelExceptionNotify\Collectors\RequestRawFileCollector::class,
        Guanguans\LaravelExceptionNotify\Collectors\RequestFileCollector::class,
        // \Guanguans\LaravelExceptionNotify\Collectors\RequestMiddlewareCollector::class,
        // \Guanguans\LaravelExceptionNotify\Collectors\RequestServerCollector::class,
        // \Guanguans\LaravelExceptionNotify\Collectors\RequestCookieCollector::class,
        // \Guanguans\LaravelExceptionNotify\Collectors\RequestSessionCollector::class,
    ],

    /**
     * The default reported channels.
     */
    'defaults' => env_explode('EXCEPTION_NOTIFY_DEFAULTS', [
        // 'bark',
        // 'chanify',
        // 'dingTalk',
        // 'discord',
        // 'dump',
        // 'feiShu',
        'log',
        // 'mail',
        // 'null',
        // 'pushDeer',
        // 'qqChannelBot',
        // 'serverChan',
        // 'slack',
        // 'telegram',
        // 'weWork',
        // 'xiZhi',
    ]),

    /**
     * The list of channels.
     */
    'channels' => [
        /**
         * Bark
         *
         * @see https://github.com/Finb/Bark
         */
        'bark' => [
            'driver' => 'bark',
            'base_uri' => env('EXCEPTION_NOTIFY_BARK_BASE_URI'),
            'token' => env('EXCEPTION_NOTIFY_BARK_TOKEN'),
            'group' => env('EXCEPTION_NOTIFY_BARK_GROUP', config('app.name')),
            'pipes' => [
                FixPrettyJsonPipe::class,
                hydrate_pipe(LimitLengthPipe::class, 1024),
            ],
        ],

        /**
         * Chanify
         *
         * @see https://github.com/chanify/chanify-ios
         */
        'chanify' => [
            'driver' => 'chanify',
            'base_uri' => env('EXCEPTION_NOTIFY_CHANIFY_BASE_URI'),
            'token' => env('EXCEPTION_NOTIFY_CHANIFY_TOKEN'),
            'pipes' => [
                FixPrettyJsonPipe::class,
                hydrate_pipe(LimitLengthPipe::class, 1024),
            ],
        ],

        /**
         * 钉钉群机器人
         *
         * @see https://developers.dingtalk.com/document/app/custom-robot-access
         */
        'dingTalk' => [
            'driver' => 'dingTalk',
            'token' => env('EXCEPTION_NOTIFY_DINGTALK_TOKEN'),
            'secret' => env('EXCEPTION_NOTIFY_DINGTALK_SECRET'),
            'keyword' => env('EXCEPTION_NOTIFY_DINGTALK_KEYWORD'),
            'pipes' => [
                hydrate_pipe(AddKeywordPipe::class, env('EXCEPTION_NOTIFY_DINGTALK_KEYWORD')),
                FixPrettyJsonPipe::class,
                hydrate_pipe(LimitLengthPipe::class, 20000),
            ],
        ],

        /**
         * Discord
         *
         * @see https://discord.com/developers/docs/resources/webhook#edit-webhook-message
         */
        'discord' => [
            'driver' => 'discord',
            'webhook_url' => env('EXCEPTION_NOTIFY_DISCORD_WEBHOOK_URL'),
            'pipes' => [
                FixPrettyJsonPipe::class,
                hydrate_pipe(LimitLengthPipe::class, 2000),
            ],
        ],

        /**
         * 飞书群机器人
         *
         * @see https://www.feishu.cn/hc/zh-CN/articles/360024984973
         */
        'feiShu' => [
            'driver' => 'feiShu',
            'token' => env('EXCEPTION_NOTIFY_FEISHU_TOKEN'),
            'secret' => env('EXCEPTION_NOTIFY_FEISHU_SECRET'),
            'keyword' => env('EXCEPTION_NOTIFY_FEISHU_KEYWORD'),
            'pipes' => [
                hydrate_pipe(AddKeywordPipe::class, env('EXCEPTION_NOTIFY_FEISHU_KEYWORD')),
                FixPrettyJsonPipe::class,
                hydrate_pipe(LimitLengthPipe::class, 30720),
            ],
        ],

        /**
         * Log
         *
         * @see Illuminate\Log\LogManager
         */
        'log' => [
            'driver' => 'log',
            'channel' => env('EXCEPTION_NOTIFY_LOG_CHANNEL', 'daily'),
            'level' => env('EXCEPTION_NOTIFY_LOG_LEVEL', 'error'),
            'pipes' => [],
        ],

        /**
         * 邮件
         *
         * 安装依赖 composer require symfony/mailer -v
         *
         * @see https://symfony.com/doc/current/mailer.html
         */
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

        /**
         * Push Deer
         *
         * @see http://pushdeer.com
         */
        'pushDeer' => [
            'driver' => 'pushDeer',
            'token' => env('EXCEPTION_NOTIFY_PUSHDEER_TOKEN'),
            'base_uri' => env('EXCEPTION_NOTIFY_PUSHDEER_BASE_URI'),
            'pipes' => [
                ToMarkdownPipe::class,
            ],
        ],

        /**
         * QQ Channel Bot
         *
         * 安装依赖 composer require textalk/websocket -v
         *
         * @see https://bot.q.qq.com/wiki/develop/api/openapi/message/post_messages.html
         */
        'qqChannelBot' => [
            'driver' => 'qqChannelBot',
            'appid' => env('EXCEPTION_NOTIFY_QQCHANNELBOT_APPID'),
            'token' => env('EXCEPTION_NOTIFY_QQCHANNELBOT_TOKEN'),
            'channel_id' => env('EXCEPTION_NOTIFY_QQCHANNELBOT_CHANNEL_ID'),
            'environment' => env('EXCEPTION_NOTIFY_QQCHANNELBOT_ENVIRONMENT', 'production'),
            'pipes' => [
                // 错误码(304003) https://bot.q.qq.com/wiki/develop/api/openapi/error/error.html
                sprintf('%s:%s,%s', ReplaceStrPipe::class, '.php', '.PHP'),
            ],
        ],

        /**
         * Server 酱
         *
         * @see https://sct.ftqq.com
         */
        'serverChan' => [
            'driver' => 'serverChan',
            'token' => env('EXCEPTION_NOTIFY_SERVERCHAN_TOKEN'),
            'pipes' => [],
        ],

        /**
         * Slack
         *
         * @see https://api.slack.com/messaging/webhooks
         */
        'slack' => [
            'driver' => 'slack',
            'webhook_url' => env('EXCEPTION_NOTIFY_SLACK_WEBHOOK_URL'),
            'channel' => env('EXCEPTION_NOTIFY_SLACK_CHANNEL'),
            'pipes' => [
                ToMarkdownPipe::class,
            ],
        ],

        /**
         * Telegram
         *
         * @see https://core.telegram.org/bots/api#sendmessage
         */
        'telegram' => [
            'driver' => 'telegram',
            'token' => env('EXCEPTION_NOTIFY_TELEGRAM_TOKEN'),
            'chat_id' => env('EXCEPTION_NOTIFY_TELEGRAM_CHAT_ID'),
            'pipes' => [
                FixPrettyJsonPipe::class,
                hydrate_pipe(LimitLengthPipe::class, 4096),
            ],
        ],

        /**
         * 企业微信群机器人
         *
         * @see https://open.work.weixin.qq.com/api/doc/90000/90136/91770
         */
        'weWork' => [
            'driver' => 'weWork',
            'token' => env('EXCEPTION_NOTIFY_WEWORK_TOKEN'),
            'pipes' => [
                FixPrettyJsonPipe::class,
                hydrate_pipe(LimitLengthPipe::class, 5120),
            ],
        ],

        /**
         * 息知
         *
         * @see https://xz.qqoq.net/#/index
         */
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
