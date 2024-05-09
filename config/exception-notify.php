<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

use Guanguans\LaravelExceptionNotify\Pipes\AddKeywordPipe;
use Guanguans\LaravelExceptionNotify\Pipes\LimitLengthPipe;
use Guanguans\LaravelExceptionNotify\Pipes\SprintfHtmlPipe;
use Guanguans\LaravelExceptionNotify\Pipes\SprintfMarkdownPipe;

return [
    /**
     * Enable or disable exception notify.
     */
    'enabled' => (bool) env('EXCEPTION_NOTIFY_ENABLED', true),

    /**
     * The rate limit of same exception.
     */
    'rate_limit' => [
        'key_prefix' => env('EXCEPTION_NOTIFY_RATE_LIMIT_KEY_PREFIX', 'exception_notify_'),
        'max_attempts' => (int) env('EXCEPTION_NOTIFY_RATE_LIMIT_MAX_ATTEMPTS', config('app.debug') ? 50 : 1),
        'decay_seconds' => (int) env('EXCEPTION_NOTIFY_RATE_LIMIT_DECAY_SECONDS', 300),
    ],

    /**
     * The options of report exception job.
     */
    'job' => [
        'connection' => env('EXCEPTION_NOTIFY_JOB_CONNECTION', config('queue.default', 'sync')),
        'queue' => env('EXCEPTION_NOTIFY_JOB_QUEUE'),
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
        Guanguans\LaravelExceptionNotify\Collectors\RequestBasicCollector::class,
        Guanguans\LaravelExceptionNotify\Collectors\ExceptionBasicCollector::class,
        Guanguans\LaravelExceptionNotify\Collectors\ExceptionContextCollector::class,
        Guanguans\LaravelExceptionNotify\Collectors\ExceptionTraceCollector::class,

        // Guanguans\LaravelExceptionNotify\Collectors\RequestCookieCollector::class,
        // Guanguans\LaravelExceptionNotify\Collectors\RequestSessionCollector::class,
        // Guanguans\LaravelExceptionNotify\Collectors\RequestMiddlewareCollector::class,
        // Guanguans\LaravelExceptionNotify\Collectors\RequestServerCollector::class,

        // Guanguans\LaravelExceptionNotify\Collectors\RequestHeaderCollector::class,
        // Guanguans\LaravelExceptionNotify\Collectors\RequestQueryCollector::class,
        // Guanguans\LaravelExceptionNotify\Collectors\RequestPostCollector::class,
        // Guanguans\LaravelExceptionNotify\Collectors\RequestFileCollector::class,
        // Guanguans\LaravelExceptionNotify\Collectors\RequestRawFileCollector::class,
    ],

    /**
     * The default reported channels.
     */
    'defaults' => env_explode('EXCEPTION_NOTIFY_DEFAULTS', [
        'log',
    ]),

    /**
     * The list of channels.
     */
    'channels' => [
        /**
         * @see \Symfony\Component\VarDumper\VarDumper::dump()
         */
        'dump' => [
            'driver' => 'dump',
        ],

        /**
         * @see \Illuminate\Log\LogManager
         */
        'log' => [
            'driver' => 'log',
            'channel' => 'daily',
        ],

        /**
         * @see \Illuminate\Mail\MailManager
         */
        'mail' => [
            'driver' => 'mail',
            'mailer' => null,
            'to' => ['users' => env('EXCEPTION_NOTIFY_MAIL_TO', 'your@example.mail')],
            'pipes' => [
                SprintfHtmlPipe::class,
            ],
        ],

        // /**
        //  * @see https://github.com/guanguans/notify#platform-support
        //  */
        // 'foo' => [
        //     'driver' => 'notify',
        //     'authenticator' => [
        //         'class' => \Guanguans\Notify\Foo\Authenticator::class,
        //         'parameter1' => '...',
        //         // ...
        //     ],
        //     'client' => [
        //         'class' => \Guanguans\Notify\Foo\Client::class,
        //         'http_options' => [],
        //         // 'extender' => \Guanguans\LaravelExceptionNotify\DefaultNotifyClientExtender::class,
        //     ],
        //     'message' => [
        //         'class' => \Guanguans\Notify\Foo\Messages\Message::class,
        //         'title' => '{report}',
        //         'content' => '{report}',
        //     ],
        //     'pipes' => [
        //         hydrate_pipe(LimitLengthPipe::class, 1024),
        //     ],
        // ],

        'bark' => [
            'driver' => 'notify',
            'authenticator' => [
                'class' => \Guanguans\Notify\Bark\Authenticator::class,
                'token' => env('EXCEPTION_NOTIFY_BARK_TOKEN'),
            ],
            'client' => [
                'class' => \Guanguans\Notify\Bark\Client::class,
                'http_options' => [],
                // 'extender' => \Guanguans\LaravelExceptionNotify\DefaultNotifyClientExtender::class,
            ],
            'message' => [
                'class' => \Guanguans\Notify\Bark\Messages\Message::class,
                'title' => '{title}',
                'body' => '{report}',
            ],
            'pipes' => [
                hydrate_pipe(LimitLengthPipe::class, 1024),
            ],
        ],

        'chanify' => [
            'driver' => 'notify',
            'authenticator' => [
                'class' => \Guanguans\Notify\Chanify\Authenticator::class,
                'token' => env('EXCEPTION_NOTIFY_CHANIFY_TOKEN'),
            ],
            'client' => [
                'class' => \Guanguans\Notify\Chanify\Client::class,
                'http_options' => [],
                // 'extender' => \Guanguans\LaravelExceptionNotify\DefaultNotifyClientExtender::class,
            ],
            'message' => [
                'class' => \Guanguans\Notify\Chanify\Messages\TextMessage::class,
                'title' => '{title}',
                'text' => '{report}',
            ],
            'pipes' => [
                hydrate_pipe(LimitLengthPipe::class, 1024),
            ],
        ],

        'dingTalk' => [
            'driver' => 'notify',
            'authenticator' => [
                'class' => \Guanguans\Notify\DingTalk\Authenticator::class,
                'token' => env('EXCEPTION_NOTIFY_DINGTALK_TOKEN'),
                'secret' => env('EXCEPTION_NOTIFY_DINGTALK_SECRET'),
            ],
            'client' => [
                'class' => \Guanguans\Notify\DingTalk\Client::class,
                'http_options' => [],
                // 'extender' => \Guanguans\LaravelExceptionNotify\DefaultNotifyClientExtender::class,
            ],
            'message' => [
                'class' => \Guanguans\Notify\DingTalk\Messages\MarkdownMessage::class,
                'title' => '{title}',
                'text' => '{report}',
            ],
            'pipes' => [
                hydrate_pipe(AddKeywordPipe::class, env('EXCEPTION_NOTIFY_DINGTALK_KEYWORD')),
                hydrate_pipe(LimitLengthPipe::class, 20000),
            ],
        ],

        'discord' => [
            'driver' => 'notify',
            'authenticator' => [
                'class' => \Guanguans\Notify\Discord\Authenticator::class,
                'webHook' => env('EXCEPTION_NOTIFY_DISCORD_WEBHOOK'),
            ],
            'client' => [
                'class' => \Guanguans\Notify\Discord\Client::class,
                'http_options' => [],
                // 'extender' => \Guanguans\LaravelExceptionNotify\DefaultNotifyClientExtender::class,
            ],
            'message' => [
                'class' => \Guanguans\Notify\Discord\Messages\Message::class,
                'content' => '{report}',
            ],
            'pipes' => [
                hydrate_pipe(LimitLengthPipe::class, 2000),
            ],
        ],

        'lark' => [
            'driver' => 'notify',
            'authenticator' => [
                'class' => \Guanguans\Notify\Lark\Authenticator::class,
                'token' => env('EXCEPTION_NOTIFY_LARK_TOKEN'),
                'secret' => env('EXCEPTION_NOTIFY_LARK_SECRET'),
            ],
            'client' => [
                'class' => \Guanguans\Notify\Lark\Client::class,
                'http_options' => [],
                // 'extender' => \Guanguans\LaravelExceptionNotify\DefaultNotifyClientExtender::class,
            ],
            'message' => [
                'class' => \Guanguans\Notify\Lark\Messages\TextMessage::class,
                'text' => '{report}',
            ],
            'pipes' => [
                hydrate_pipe(AddKeywordPipe::class, env('EXCEPTION_NOTIFY_LARK_KEYWORD')),
                hydrate_pipe(LimitLengthPipe::class, 30720),
            ],
        ],

        'ntfy' => [
            'driver' => 'notify',
            'authenticator' => [
                'class' => \Guanguans\Notify\Ntfy\Authenticator::class,
                'usernameOrToken' => env('EXCEPTION_NOTIFY_NTFY_USERNAMEORTOKEN'),
                'password' => env('EXCEPTION_NOTIFY_NTFY_PASSWORD'),
            ],
            'client' => [
                'class' => \Guanguans\Notify\Ntfy\Client::class,
                'http_options' => [],
                // 'extender' => \Guanguans\LaravelExceptionNotify\DefaultNotifyClientExtender::class,
            ],
            'message' => [
                'class' => \Guanguans\Notify\Ntfy\Messages\Message::class,
                'topic' => env('EXCEPTION_NOTIFY_NTFY_TOPIC', 'laravel-exception-notify'),
                'title' => '{title}',
                'message' => '{report}',
            ],
            'pipes' => [
                hydrate_pipe(LimitLengthPipe::class, 1024),
            ],
        ],

        'pushDeer' => [
            'driver' => 'notify',
            'authenticator' => [
                'class' => \Guanguans\Notify\PushDeer\Authenticator::class,
                'token' => env('EXCEPTION_NOTIFY_PUSHDEER_TOKEN'),
            ],
            'client' => [
                'class' => \Guanguans\Notify\PushDeer\Client::class,
                'http_options' => [],
                // 'extender' => \Guanguans\LaravelExceptionNotify\DefaultNotifyClientExtender::class,
            ],
            'message' => [
                'class' => \Guanguans\Notify\PushDeer\Messages\Message::class,
                'type' => 'markdown',
                'text' => '{title}',
                'desp' => '{report}',
            ],
            'pipes' => [
                SprintfMarkdownPipe::class,
                hydrate_pipe(LimitLengthPipe::class, 1024),
            ],
        ],

        'slack' => [
            'driver' => 'notify',
            'authenticator' => [
                'class' => \Guanguans\Notify\Slack\Authenticator::class,
                'webHook' => env('EXCEPTION_NOTIFY_SLACK_WEBHOOK'),
            ],
            'client' => [
                'class' => \Guanguans\Notify\Slack\Client::class,
                'http_options' => [],
                // 'extender' => \Guanguans\LaravelExceptionNotify\DefaultNotifyClientExtender::class,
            ],
            'message' => [
                'class' => \Guanguans\Notify\Slack\Messages\Message::class,
                'text' => '{report}',
            ],
            'pipes' => [
                SprintfMarkdownPipe::class,
                hydrate_pipe(LimitLengthPipe::class, 4096),
            ],
        ],

        'telegram' => [
            'driver' => 'notify',
            'authenticator' => [
                'class' => \Guanguans\Notify\Telegram\Authenticator::class,
                'token' => env('EXCEPTION_NOTIFY_TELEGRAM_TOKEN'),
            ],
            'client' => [
                'class' => \Guanguans\Notify\Telegram\Client::class,
                'http_options' => [],
                // 'extender' => \Guanguans\LaravelExceptionNotify\DefaultNotifyClientExtender::class,
            ],
            'message' => [
                'class' => \Guanguans\Notify\Telegram\Messages\TextMessage::class,
                'chat_id' => env('EXCEPTION_NOTIFY_TELEGRAM_CHAT_ID'),
                'text' => '{report}',
            ],
            'pipes' => [
                hydrate_pipe(LimitLengthPipe::class, 4096),
            ],
        ],

        'weWork' => [
            'driver' => 'notify',
            'authenticator' => [
                'class' => \Guanguans\Notify\WeWork\Authenticator::class,
                'token' => env('EXCEPTION_NOTIFY_WEWORK_TOKEN'),
            ],
            'client' => [
                'class' => \Guanguans\Notify\WeWork\Client::class,
                'http_options' => [],
                // 'extender' => \Guanguans\LaravelExceptionNotify\DefaultNotifyClientExtender::class,
            ],
            'message' => [
                'class' => \Guanguans\Notify\WeWork\Messages\MarkdownMessage::class,
                'content' => '{report}',
            ],
            'pipes' => [
                hydrate_pipe(LimitLengthPipe::class, 5120),
            ],
        ],
    ],
];
