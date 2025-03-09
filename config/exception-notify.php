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

use Guanguans\LaravelExceptionNotify\Channels\AbstractChannel;
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
use Guanguans\LaravelExceptionNotify\Collectors\RequestServerCollector;
use Guanguans\LaravelExceptionNotify\Jobs\ReportExceptionJob;
use Guanguans\LaravelExceptionNotify\Pipes\AddKeywordChorePipe;
use Guanguans\LaravelExceptionNotify\Pipes\LimitLengthPipe;
use Guanguans\LaravelExceptionNotify\Pipes\SprintfHtmlPipe;
use Guanguans\LaravelExceptionNotify\Pipes\SprintfMarkdownPipe;
use function Guanguans\LaravelExceptionNotify\Support\env_explode;

return [
    /**
     * Enable or disable exception notify.
     */
    'enabled' => (bool) env('EXCEPTION_NOTIFY_ENABLED', true),

    /**
     * The list of environments that should be reported.
     */
    'environments' => env_explode('EXCEPTION_NOTIFY_ENVIRONMENTS', [
        // 'production',
        // 'local',
        // 'testing',
        '*',
    ]),

    /**
     * The rate limit of same exception.
     */
    'rate_limit' => [
        'cache_store' => env('EXCEPTION_NOTIFY_RATE_LIMIT_CACHE_STORE', config('cache.default')),
        'key_prefix' => env('EXCEPTION_NOTIFY_RATE_LIMIT_KEY_PREFIX', 'exception_notify_'),
        'max_attempts' => (int) env('EXCEPTION_NOTIFY_RATE_LIMIT_MAX_ATTEMPTS', config('app.debug') ? 50 : 1),
        'decay_seconds' => (int) env('EXCEPTION_NOTIFY_RATE_LIMIT_DECAY_SECONDS', 300),
    ],

    /**
     * The options of report exception job.
     */
    'job' => [
        'class' => ReportExceptionJob::class,
        'connection' => env('EXCEPTION_NOTIFY_JOB_CONNECTION', config('queue.default')),
        'queue' => env('EXCEPTION_NOTIFY_JOB_QUEUE'),
    ],

    /**
     * The title of exception notification report.
     */
    'title' => env('EXCEPTION_NOTIFY_TITLE', \sprintf('The %s application exception report', config('app.name'))),

    /**
     * The list of collector.
     */
    'collectors' => [
        ApplicationCollector::class,
        // PhpInfoCollector::class,
        ChoreCollector::class,
        RequestBasicCollector::class,
        ExceptionBasicCollector::class,
        ExceptionContextCollector::class => ['mark' => '', 'lineNumber' => 5],
        ExceptionTraceCollector::class,

        // RequestHeaderCollector::class,
        // RequestQueryCollector::class,
        // RequestPostCollector::class,
        // RequestFileCollector::class,
        // RequestRawFileCollector::class,
        // RequestServerCollector::class,
    ],

    /**
     * The default reported channels.
     */
    'default' => env('EXCEPTION_NOTIFY_DEFAULT', 'stack'),

    /**
     * The list of channels.
     */
    'channels' => [
        /**
         * @see \Symfony\Component\VarDumper\VarDumper::dump()
         */
        'stack' => [
            'driver' => 'stack',
            'channels' => [
                'log',
            ],
        ],

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
            'channel' => null,
        ],

        /**
         * @see \Illuminate\Mail\MailManager
         */
        'mail' => [
            'driver' => 'mail',
            'mailer' => null,
            'to' => [
                'users' => env_explode('EXCEPTION_NOTIFY_MAIL_TO_USERS', [
                    'your@example.mail',
                ]),
            ],
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
        //         'title' => AbstractChannel::CONTENT_TEMPLATE,
        //         'content' => AbstractChannel::CONTENT_TEMPLATE,
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
                'title' => AbstractChannel::TITLE_TEMPLATE,
                'body' => AbstractChannel::CONTENT_TEMPLATE,
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
                'title' => AbstractChannel::TITLE_TEMPLATE,
                'text' => AbstractChannel::CONTENT_TEMPLATE,
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
                'title' => AbstractChannel::TITLE_TEMPLATE,
                'text' => AbstractChannel::CONTENT_TEMPLATE,
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
                'content' => AbstractChannel::CONTENT_TEMPLATE,
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
                'text' => AbstractChannel::CONTENT_TEMPLATE,
            ],
            'pipes' => [
                AddKeywordChorePipe::with(env('EXCEPTION_NOTIFY_LARK_KEYWORD')),
                LimitLengthPipe::with(30720),
            ],
        ],

        'ntfy' => [
            'driver' => 'notify',
            'authenticator' => [
                'class' => Guanguans\Notify\Foundation\Authenticators\NullAuthenticator::class,
                // 'class' => \Guanguans\Notify\Ntfy\Authenticator::class,
                // 'usernameOrToken' => env('EXCEPTION_NOTIFY_NTFY_USERNAMEORTOKEN', ''),
                // 'password' => env('EXCEPTION_NOTIFY_NTFY_PASSWORD', ''),
            ],
            'client' => [
                'class' => Guanguans\Notify\Ntfy\Client::class,
            ],
            'message' => [
                'class' => Guanguans\Notify\Ntfy\Messages\Message::class,
                'topic' => env('EXCEPTION_NOTIFY_NTFY_TOPIC', 'laravel-exception-notify'),
                'title' => AbstractChannel::TITLE_TEMPLATE,
                'message' => AbstractChannel::CONTENT_TEMPLATE,
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
                'type' => 'markdown',
                'text' => AbstractChannel::TITLE_TEMPLATE,
                'desp' => AbstractChannel::CONTENT_TEMPLATE,
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
                'mrkdwn' => true,
                'text' => AbstractChannel::CONTENT_TEMPLATE,
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
                'chat_id' => env('EXCEPTION_NOTIFY_TELEGRAM_CHAT_ID'),
                'text' => AbstractChannel::CONTENT_TEMPLATE,
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
                'content' => AbstractChannel::CONTENT_TEMPLATE,
            ],
            'pipes' => [
                SprintfMarkdownPipe::class,
                LimitLengthPipe::with(4096),
            ],
        ],
    ],
];
