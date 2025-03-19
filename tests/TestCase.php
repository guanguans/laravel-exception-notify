<?php

/** @noinspection PhpMissingParentCallCommonInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2021-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

namespace Guanguans\LaravelExceptionNotifyTests;

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
use Guanguans\LaravelExceptionNotify\ExceptionNotifyServiceProvider;
use Guanguans\LaravelExceptionNotify\Exceptions\RuntimeException;
use Guanguans\LaravelExceptionNotify\Facades\ExceptionNotify;
use Guanguans\LaravelExceptionNotify\Pipes\AddKeywordChorePipe;
use Guanguans\LaravelExceptionNotify\Pipes\FixPrettyJsonPipe;
use Guanguans\LaravelExceptionNotify\Pipes\LimitLengthPipe;
use Guanguans\LaravelExceptionNotify\Pipes\SprintfHtmlPipe;
use Guanguans\LaravelExceptionNotify\Pipes\SprintfMarkdownPipe;
use Guanguans\Notify\Foundation\Client;
use Guanguans\Notify\Foundation\Response;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Log;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Symfony\Component\VarDumper\Test\VarDumperTestTrait;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use Faker;
    use MockeryPHPUnitIntegration;
    use VarDumperTestTrait;

    protected function setUp(): void
    {
        parent::setUp();
        $this->startMockery();
    }

    protected function tearDown(): void
    {
        $this->closeMockery();
        parent::tearDown();
    }

    protected function getPackageProviders($app): array
    {
        return [
            ExceptionNotifyServiceProvider::class,
            ...parent::getPackageProviders($app),
        ];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'ExceptionNotify' => ExceptionNotify::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        config()->set('exception-notify.collectors', [
            ApplicationCollector::class,
            ChoreCollector::class,
            ExceptionBasicCollector::class,
            ExceptionContextCollector::class,
            ExceptionTraceCollector::class,
            PhpInfoCollector::class,
            RequestBasicCollector::class,
            RequestFileCollector::class,
            RequestHeaderCollector::class,
            RequestPostCollector::class,
            RequestQueryCollector::class,
            RequestRawFileCollector::class,
        ]);
        config()->set('exception-notify.channels.log.pipes', [
            AddKeywordChorePipe::with('keyword'),
            SprintfHtmlPipe::class,
            SprintfMarkdownPipe::class,
            FixPrettyJsonPipe::class,
            LimitLengthPipe::with(512),
        ]);

        collect(config('exception-notify.channels'))->each(static function (array $configuration, string $name): void {
            if ('notify' === ($configuration['driver'] ?? $name)) {
                config()->set(
                    "exception-notify.channels.$name.client.extender",
                    static fn (Client $client): Client => $client
                        ->mock([
                            new \GuzzleHttp\Psr7\Response(body: $name),
                        ])
                        // ->before(
                        //     \Guanguans\Notify\Foundation\Middleware\Response::class,
                        //     Middleware::mapResponse(static fn (Response $response): Response => $response->dump()),
                        // )
                        ->push(Middleware::log(Log::channel(), new MessageFormatter(MessageFormatter::DEBUG), 'debug'))
                );
            }
        });
    }

    protected function defineRoutes($router): void
    {
        $router->any(
            'proactive-report-exception',
            static fn () => tap(
                response('proactive-report-exception'),
                static function (): void {
                    config()->set('exception-notify.channels.stack.channels', [
                        'dump',
                        'log',
                        'mail',
                        'bark',
                        'chanify',
                        'dingTalk',
                        'discord',
                        'lark',
                        'ntfy',
                        'pushDeer',
                        'slack',
                        'telegram',
                        'weWork',
                    ]);

                    ExceptionNotify::report(new RuntimeException('What happened?'));
                }
            )
        );

        $router->any(
            'automatic-report-exception',
            static fn () => tap(response('automatic-report-exception'), static function (): void {
                throw new RuntimeException('What happened?');
            })
        );
    }
}
