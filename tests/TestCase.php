<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpFieldAssignmentTypeMismatchInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */
/** @noinspection StaticClosureCanBeUsedInspection */
/** @noinspection EfferentObjectCouplingInspection */
/** @noinspection PhpMissingParentCallCommonInspection */
declare(strict_types=1);

/**
 * Copyright (c) 2021-2026 guanguans<ityaozm@gmail.com>
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
use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Orchestra\Testbench\Concerns\WithWorkbench;
use phpmock\phpunit\PHPMock;
use Symfony\Component\VarDumper\Test\VarDumperTestTrait;

class TestCase extends \Orchestra\Testbench\TestCase
{
    // use DatabaseMigrations;
    // use DatabaseTransactions;
    // use DatabaseTruncation;
    // use InteractsWithViews;
    // use LazilyRefreshDatabase;
    // use WithCachedConfig;
    // use WithCachedRoutes;

    // use VarDumperTestTrait;
    // use PHPMock;

    // use RefreshDatabase;
    use WithWorkbench;

    protected function getApplicationTimezone(mixed $app): string
    {
        return 'Asia/Shanghai';
    }

    protected function getPackageAliases($app): array
    {
        return [
            'ExceptionNotify' => ExceptionNotify::class,
        ];
    }

    protected function defineEnvironment(mixed $app): void
    {
        tap($app, static function (Application $_): void {
            Channel::flush();
            File::delete(glob(storage_path('logs/*.log')));
            Mail::fake();
            // Queue::fake();
        });

        tap($app->make(Repository::class), static function (Repository $repository): void {
            $repository->set('app.key', 'base64:UZ5sDPZSB7DSLKY+DYlU8G/V1e/qW+Ag0WF03VNxiSg=');
            $repository->set('database.default', 'sqlite');
            $repository->set('database.connections.sqlite.database', ':memory:');
            // $repository->set('mail.default', 'log');
        });

        tap($app->make(Repository::class), static function (Repository $repository): void {
            $repository->set('exception-notify.job.connection', 'sync');
            $repository->set('exception-notify.rate_limiter.max_attempts', \PHP_INT_MAX);

            $repository->set('exception-notify.collectors', [
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

            $repository->set('exception-notify.channels.mail.pipes', [
                AddKeywordChorePipe::with('keyword'),
                SprintfHtmlPipe::class,
                SprintfMarkdownPipe::class,
                FixPrettyJsonPipe::class,
                LimitLengthPipe::with(512),
            ]);

            $repository->set([
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

            collect($repository->get('exception-notify.channels'))->each(
                static function (array $configuration, string $name) use ($repository): void {
                    if ('notify' === ($configuration['driver'] ?? $name)) {
                        $repository->set(
                            "exception-notify.channels.$name.client.extender",
                            static fn (Client $client): Client => $client
                                ->mock([new Response(body: $name)])
                                ->push(Middleware::log(Log::channel(), new MessageFormatter(MessageFormatter::DEBUG), 'debug'))
                        );
                    }
                }
            );
        });
    }

    /**
     * @see tests/ArchTest.php
     */
    protected function defineRoutes(mixed $router): void
    {
        require __DIR__.'/../workbench/routes/web.php';
    }
}
