<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

use Guanguans\LaravelExceptionNotify\Collectors\ApplicationCollector;
use Guanguans\LaravelExceptionNotify\Collectors\ChoreCollector;
use Guanguans\LaravelExceptionNotify\Collectors\ExceptionBasicCollector;
use Guanguans\LaravelExceptionNotify\Collectors\ExceptionContextCollector;
use Guanguans\LaravelExceptionNotify\Collectors\ExceptionTraceCollector;
use Guanguans\LaravelExceptionNotify\Collectors\PhpInfoCollector;
use Guanguans\LaravelExceptionNotify\Collectors\RequestBasicCollector;
use Guanguans\LaravelExceptionNotify\Collectors\RequestFileCollector;
use Guanguans\LaravelExceptionNotify\Collectors\RequestHeaderCollector;
use Guanguans\LaravelExceptionNotify\Collectors\RequestPostCollector;
use Guanguans\LaravelExceptionNotify\Collectors\RequestQueryCollector;
use Guanguans\LaravelExceptionNotify\Collectors\RequestRawFileCollector;
use Guanguans\LaravelExceptionNotify\Jobs\ReportExceptionJob;
use Guanguans\LaravelExceptionNotify\Mail\ReportExceptionMail;
use Guanguans\LaravelExceptionNotify\Pipes\AddKeywordChorePipe;
use Guanguans\LaravelExceptionNotify\Pipes\LimitLengthPipe;
use Guanguans\LaravelExceptionNotify\Pipes\SprintfHtmlPipe;
use Guanguans\LaravelExceptionNotify\Pipes\SprintfMarkdownPipe;
use Guanguans\LaravelExceptionNotify\Template;
use function Guanguans\LaravelExceptionNotify\Support\env_explode;

return [
    /**
     * The switch of auto report exception.
     */
    'enabled' => (bool) env('EXCEPTION_NOTIFY_ENABLED', true),

    /**
     * The list of environment that report exception.
     */
    'environments' => env_explode('EXCEPTION_NOTIFY_ENVIRONMENTS', [
        // 'local',
        // 'production',
        // 'testing',
        '*',
    ]),

    /**
     * The rate limiter of report same exception.
     */
    'rate_limiter' => [
        'cache_store' => env('EXCEPTION_NOTIFY_RATE_LIMITER_CACHE_STORE'),
        'key_prefix' => env('EXCEPTION_NOTIFY_RATE_LIMITER_KEY_PREFIX', 'exception-notify:rate-limiter:'),
        'max_attempts' => (int) env('EXCEPTION_NOTIFY_RATE_LIMITER_MAX_ATTEMPTS', config('app.debug') ? \PHP_INT_MAX : 1),
        'decay_seconds' => (int) env('EXCEPTION_NOTIFY_RATE_LIMITER_DECAY_SECONDS', 300),
    ],

    /**
     * The job of report exception.
     */
    'job' => [
        'class' => ReportExceptionJob::class,
        'connection' => env('EXCEPTION_NOTIFY_JOB_CONNECTION'),
        'queue' => env('EXCEPTION_NOTIFY_JOB_QUEUE'),
    ],

    /**
     * The title of report exception.
     */
    'title' => env('EXCEPTION_NOTIFY_TITLE', \sprintf('The %s application exception report', config('app.name'))),

    /**
     * The list of collector that report exception.
     */
    'collectors' => [
        ApplicationCollector::class,
        // PhpInfoCollector::class,
        ChoreCollector::class,
        RequestBasicCollector::class,
        ExceptionBasicCollector::class,
        ExceptionContextCollector::class,
        ExceptionTraceCollector::class,

        // RequestHeaderCollector::class,
        // RequestQueryCollector::class,
        // RequestPostCollector::class,
        // RequestFileCollector::class,
        // RequestRawFileCollector::class,
    ],

    /**
     * The default channel of report exception.
     */
    'default' => env('EXCEPTION_NOTIFY_CHANNEL', 'stack'),

    /**
     * The list of channel that report exception.
     */
    'channels' => [
        /**
         * @see \Guanguans\LaravelExceptionNotify\Channels\StackChannel
         */
        'stack' => [
            'driver' => 'stack',
            'channels' => env_explode('EXCEPTION_NOTIFY_STACK_CHANNELS', [
                // 'dump',
                'log',
                // 'mail',
                // 'bark',
                // 'chanify',
                // 'dingTalk',
                // 'discord',
                // 'lark',
                // 'ntfy',
                // 'pushDeer',
                // 'slack',
                // 'telegram',
                // 'weWork',
            ]),
        ],

        /**
         * @see \Guanguans\LaravelExceptionNotify\Channels\DumpChannel
         */
        'dump' => [
            'driver' => 'dump',
            'exit' => env('EXCEPTION_NOTIFY_DUMP_EXIT', false),
        ],

        /**
         * @see \Guanguans\LaravelExceptionNotify\Channels\LogChannel
         */
        'log' => [
            'driver' => 'log',
            'channel' => env('EXCEPTION_NOTIFY_LOG_CHANNEL'),
            'level' => env('EXCEPTION_NOTIFY_LOG_LEVEL', 'error'),
        ],

        /**
         * @see \Guanguans\LaravelExceptionNotify\Channels\MailChannel
         */
        'mail' => [
            'driver' => 'mail',
            'mailer' => env('EXCEPTION_NOTIFY_MAIL_MAILER'),
            'class' => ReportExceptionMail::class,
            'title' => Template::TITLE,
            'content' => Template::CONTENT,
            'to' => [
                'address' => env_explode('EXCEPTION_NOTIFY_MAIL_TO_ADDRESS', [
                    'your@example.mail',
                ]),
            ],
            'pipes' => [
                SprintfHtmlPipe::class,
            ],
        ],

        /**
         * @see \Guanguans\LaravelExceptionNotify\Channels\NotifyChannel
         * @see https://github.com/guanguans/notify
         */
        // 'foo' => [
        //     'driver' => 'notify',
        //     'authenticator' => [
        //         'class' => Guanguans\Notify\Foo\Authenticator::class,
        //         'parameter1' => '...',
        //         // ...
        //     ],
        //     'client' => [
        //         'class' => Guanguans\Notify\Foo\Client::class,
        //         'http_options' => [],
        //         'extender' => static fn (Guanguans\Notify\Foundation\Client $client) => $client->push(
        //             GuzzleHttp\Middleware::log(
        //                 Illuminate\Support\Facades\Log::channel(),
        //                 new GuzzleHttp\MessageFormatter(GuzzleHttp\MessageFormatter::DEBUG),
        //                 'debug'
        //             ),
        //         ),
        //     ],
        //     'message' => [
        //         'class' => Guanguans\Notify\Foo\Messages\Message::class,
        //         'options' => [
        //             'title' => Template::CONTENT,
        //             'content' => Template::CONTENT,
        //         ],
        //     ],
        //     'pipes' => [
        //         LimitLengthPipe::with(1024),
        //     ],
        // ],

        'bark' => [
            'driver' => 'notify',
            'authenticator' => [
                'class' => Guanguans\Notify\Bark\Authenticator::class,
                'token' => env('EXCEPTION_NOTIFY_BARK_TOKEN'),
            ],
            'client' => [
                'class' => Guanguans\Notify\Bark\Client::class,
            ],
            'message' => [
                'class' => Guanguans\Notify\Bark\Messages\Message::class,
                'options' => [
                    'title' => Template::TITLE,
                    'body' => Template::CONTENT,
                ],
            ],
            'pipes' => [
                LimitLengthPipe::with(4096),
            ],
        ],

        'chanify' => [
            'driver' => 'notify',
            'authenticator' => [
                'class' => Guanguans\Notify\Chanify\Authenticator::class,
                'token' => env('EXCEPTION_NOTIFY_CHANIFY_TOKEN'),
            ],
            'client' => [
                'class' => Guanguans\Notify\Chanify\Client::class,
            ],
            'message' => [
                'class' => Guanguans\Notify\Chanify\Messages\TextMessage::class,
                'options' => [
                    'title' => Template::TITLE,
                    'text' => Template::CONTENT,
                ],
            ],
            'pipes' => [
                LimitLengthPipe::with(1024),
            ],
        ],

        'dingTalk' => [
            'driver' => 'notify',
            'authenticator' => [
                'class' => Guanguans\Notify\DingTalk\Authenticator::class,
                'token' => env('EXCEPTION_NOTIFY_DINGTALK_TOKEN'),
                'secret' => env('EXCEPTION_NOTIFY_DINGTALK_SECRET'),
            ],
            'client' => [
                'class' => Guanguans\Notify\DingTalk\Client::class,
            ],
            'message' => [
                'class' => Guanguans\Notify\DingTalk\Messages\MarkdownMessage::class,
                'options' => [
                    'title' => Template::TITLE,
                    'text' => Template::CONTENT,
                ],
            ],
            'pipes' => [
                AddKeywordChorePipe::with(env('EXCEPTION_NOTIFY_DINGTALK_KEYWORD')),
                SprintfMarkdownPipe::class,
                LimitLengthPipe::with(20000),
            ],
        ],

        'discord' => [
            'driver' => 'notify',
            'authenticator' => [
                'class' => Guanguans\Notify\Discord\Authenticator::class,
                'webHook' => env('EXCEPTION_NOTIFY_DISCORD_WEBHOOK'),
            ],
            'client' => [
                'class' => Guanguans\Notify\Discord\Client::class,
            ],
            'message' => [
                'class' => Guanguans\Notify\Discord\Messages\Message::class,
                'options' => [
                    'content' => Template::CONTENT,
                ],
            ],
            'pipes' => [
                LimitLengthPipe::with(2000),
            ],
        ],

        'lark' => [
            'driver' => 'notify',
            'authenticator' => [
                'class' => Guanguans\Notify\Lark\Authenticator::class,
                'token' => env('EXCEPTION_NOTIFY_LARK_TOKEN'),
                'secret' => env('EXCEPTION_NOTIFY_LARK_SECRET'),
            ],
            'client' => [
                'class' => Guanguans\Notify\Lark\Client::class,
            ],
            'message' => [
                'class' => Guanguans\Notify\Lark\Messages\TextMessage::class,
                'options' => [
                    'text' => Template::CONTENT,
                ],
            ],
            'pipes' => [
                AddKeywordChorePipe::with(env('EXCEPTION_NOTIFY_LARK_KEYWORD')),
                LimitLengthPipe::with(30720),
            ],
        ],

        'ntfy' => [
            'driver' => 'notify',
            'authenticator' => [
                'class' => Guanguans\Notify\Ntfy\Authenticator::class,
                'usernameOrToken' => env('EXCEPTION_NOTIFY_NTFY_USERNAMEORTOKEN'),
                'password' => env('EXCEPTION_NOTIFY_NTFY_PASSWORD'),
            ],
            'client' => [
                'class' => Guanguans\Notify\Ntfy\Client::class,
            ],
            'message' => [
                'class' => Guanguans\Notify\Ntfy\Messages\Message::class,
                'options' => [
                    'topic' => env('EXCEPTION_NOTIFY_NTFY_TOPIC', 'laravel-exception-notify'),
                    'title' => Template::TITLE,
                    'message' => Template::CONTENT,
                ],
            ],
            'pipes' => [
                LimitLengthPipe::with(4096),
            ],
        ],

        'pushDeer' => [
            'driver' => 'notify',
            'authenticator' => [
                'class' => Guanguans\Notify\PushDeer\Authenticator::class,
                'token' => env('EXCEPTION_NOTIFY_PUSHDEER_TOKEN'),
            ],
            'client' => [
                'class' => Guanguans\Notify\PushDeer\Client::class,
            ],
            'message' => [
                'class' => Guanguans\Notify\PushDeer\Messages\Message::class,
                'options' => [
                    'type' => 'markdown',
                    'text' => Template::TITLE,
                    'desp' => Template::CONTENT,
                ],
            ],
            'pipes' => [
                SprintfMarkdownPipe::class,
                // LimitLengthPipe::with(4096),
            ],
        ],

        'slack' => [
            'driver' => 'notify',
            'authenticator' => [
                'class' => Guanguans\Notify\Slack\Authenticator::class,
                'webHook' => env('EXCEPTION_NOTIFY_SLACK_WEBHOOK'),
            ],
            'client' => [
                'class' => Guanguans\Notify\Slack\Client::class,
            ],
            'message' => [
                'class' => Guanguans\Notify\Slack\Messages\Message::class,
                'options' => [
                    'mrkdwn' => true,
                    'text' => Template::CONTENT,
                ],
            ],
            'pipes' => [
                SprintfMarkdownPipe::class,
                // LimitLengthPipe::with(10240),
            ],
        ],

        'telegram' => [
            'driver' => 'notify',
            'authenticator' => [
                'class' => Guanguans\Notify\Telegram\Authenticator::class,
                'token' => env('EXCEPTION_NOTIFY_TELEGRAM_TOKEN'),
            ],
            'client' => [
                'class' => Guanguans\Notify\Telegram\Client::class,
            ],
            'message' => [
                'class' => Guanguans\Notify\Telegram\Messages\TextMessage::class,
                'options' => [
                    'chat_id' => env('EXCEPTION_NOTIFY_TELEGRAM_CHAT_ID'),
                    'text' => Template::CONTENT,
                ],
            ],
            'pipes' => [
                LimitLengthPipe::with(4096),
            ],
        ],

        'weWork' => [
            'driver' => 'notify',
            'authenticator' => [
                'class' => Guanguans\Notify\WeWork\Authenticator::class,
                'token' => env('EXCEPTION_NOTIFY_WEWORK_TOKEN'),
            ],
            'client' => [
                'class' => Guanguans\Notify\WeWork\Client::class,
            ],
            'message' => [
                'class' => Guanguans\Notify\WeWork\Messages\MarkdownMessage::class,
                'options' => [
                    'content' => Template::CONTENT,
                ],
            ],
            'pipes' => [
                SprintfMarkdownPipe::class,
                LimitLengthPipe::with(4096),
            ],
        ],
    ],
];
