<?php

/** @noinspection EfferentObjectCouplingInspection */
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

use Guanguans\LaravelExceptionNotify\Channels\Channel;
use Guanguans\LaravelExceptionNotify\Collectors\ApplicationCollector;
use Guanguans\LaravelExceptionNotify\Collectors\ChoreCollector;
use Guanguans\LaravelExceptionNotify\Collectors\ExceptionBasicCollector;
use Guanguans\LaravelExceptionNotify\Collectors\ExceptionContextCollector;
use Guanguans\LaravelExceptionNotify\Collectors\ExceptionTraceCollector;
use Guanguans\LaravelExceptionNotify\Collectors\RequestBasicCollector;
use Guanguans\LaravelExceptionNotify\Collectors\RequestFileCollector;
use Guanguans\LaravelExceptionNotify\Collectors\RequestHeaderCollector;
use Guanguans\LaravelExceptionNotify\Collectors\RequestPostCollector;
use Guanguans\LaravelExceptionNotify\Collectors\RequestQueryCollector;
use Guanguans\LaravelExceptionNotify\ExceptionNotifyServiceProvider;
use Guanguans\LaravelExceptionNotify\Exceptions\RuntimeException;
use Guanguans\LaravelExceptionNotify\Facades\ExceptionNotify;
use Guanguans\LaravelExceptionNotify\Pipes\AddKeywordChorePipe;
use Guanguans\LaravelExceptionNotify\Pipes\FixPrettyJsonPipe;
use Guanguans\LaravelExceptionNotify\Pipes\LimitLengthPipe;
use Guanguans\LaravelExceptionNotify\Pipes\SprintfHtmlPipe;
use Guanguans\LaravelExceptionNotify\Pipes\SprintfMarkdownPipe;
use Guanguans\Notify\Foundation\Client;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use phpmock\phpunit\PHPMock;
use Symfony\Component\VarDumper\Test\VarDumperTestTrait;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use Faker;
    use MockeryPHPUnitIntegration;
    use PHPMock;
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
        Channel::flush();
        File::delete(glob(storage_path('logs/*.log')));
        Mail::fake();
        // Queue::fake();

        config()->set('database.default', 'testing');
        config()->set('exception-notify.job.connection', 'sync');
        config()->set('exception-notify.rate_limiter.max_attempts', \PHP_INT_MAX);

        config()->set('exception-notify.collectors', [
            ApplicationCollector::class,
            ChoreCollector::class,
            ExceptionBasicCollector::class,
            ExceptionContextCollector::class,
            ExceptionTraceCollector::class,
            RequestBasicCollector::class,
            RequestFileCollector::class,
            RequestHeaderCollector::class,
            RequestPostCollector::class,
            RequestQueryCollector::class,
        ]);

        config()->set('exception-notify.channels.mail.pipes', [
            AddKeywordChorePipe::with('keyword'),
            SprintfHtmlPipe::class,
            SprintfMarkdownPipe::class,
            FixPrettyJsonPipe::class,
            LimitLengthPipe::with(512),
        ]);

        config([
            'exception-notify.channels.bark.authenticator.token' => fake()->uuid(),
            'exception-notify.channels.chanify.authenticator.token' => fake()->uuid(),
            'exception-notify.channels.dingTalk.authenticator.token' => fake()->uuid(),
            'exception-notify.channels.discord.authenticator.webHook' => fake()->url(),
            'exception-notify.channels.lark.authenticator.token' => fake()->uuid(),
            'exception-notify.channels.ntfy.authenticator.usernameOrToken' => fake()->uuid(),
            'exception-notify.channels.pushDeer.authenticator.token' => fake()->uuid(),
            'exception-notify.channels.slack.authenticator.webHook' => fake()->url(),
            'exception-notify.channels.telegram.authenticator.token' => fake()->uuid(),
            'exception-notify.channels.weWork.authenticator.token' => fake()->uuid(),
        ]);

        collect(config('exception-notify.channels'))->each(static function (array $configuration, string $name): void {
            if ('notify' === ($configuration['driver'] ?? $name)) {
                config()->set(
                    "exception-notify.channels.$name.client.extender",
                    static fn (Client $client): Client => $client
                        ->mock([
                            new Response(body: $name),
                        ])
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
                    ExceptionNotify::report(new RuntimeException('What happened?'));
                }
            )
        );

        $router->any(
            'automatic-report-exception',
            static fn () => tap(response('automatic-report-exception'), static function (): void {
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

                throw new RuntimeException('What happened?');
            })
        );
    }
}
