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
use Guanguans\LaravelExceptionNotify\Pipes\FixPrettyJsonPipe;
use Guanguans\LaravelExceptionNotify\Pipes\LimitLengthPipe;
use Guanguans\LaravelExceptionNotify\ReportUsingCreator;

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
     * The rate limit of same exception.
     */
    'rate_limit' => [
        'key_prefix' => env('EXCEPTION_NOTIFY_RATE_LIMIT_KEY_PREFIX', 'exception-notify-'),
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
     * The creator of report using.
     */
    'report_using_creator' => env('EXCEPTION_NOTIFY_REPORT_USING_CREATOR', ReportUsingCreator::class),

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
         * 飞书群机器人.
         */
        'lark' => [
            'driver' => 'notify',
            'authenticator' => [
                'class' => \Guanguans\Notify\Lark\Authenticator::class,
                'token' => '...',
                'secret' => '...',
            ],
            'client' => [
                'class' => \Guanguans\Notify\Lark\Client::class,
                'http_options' => [],
                'tapper' => static function (\Guanguans\Notify\Lark\Client $client): void {},
            ],
            'message' => [
                'class' => \Guanguans\Notify\Lark\Messages\TextMessage::class,
                'text' => '{report}',
            ],
            'pipes' => [
                hydrate_pipe(AddKeywordPipe::class, 'keyword'),
                FixPrettyJsonPipe::class,
                hydrate_pipe(LimitLengthPipe::class, 30720),
            ],
        ],

        /**
         * Log.
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
         * 企业微信群机器人.
         */
        'weWork' => [
            'driver' => 'weWork',
            'token' => env('EXCEPTION_NOTIFY_WEWORK_TOKEN'),
            'pipes' => [
                FixPrettyJsonPipe::class,
                hydrate_pipe(LimitLengthPipe::class, 5120),
            ],
        ],
    ],
];
