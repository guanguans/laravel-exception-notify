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

namespace Guanguans\LaravelExceptionNotify\Tests;

use Guanguans\LaravelExceptionNotify\Collectors\ApplicationCollector;
use Guanguans\LaravelExceptionNotify\Collectors\ChoreCollector;
use Guanguans\LaravelExceptionNotify\Collectors\ExceptionBasicCollector;
use Guanguans\LaravelExceptionNotify\Collectors\ExceptionContextCollector;
use Guanguans\LaravelExceptionNotify\Collectors\ExceptionTraceCollector;
use Guanguans\LaravelExceptionNotify\Collectors\PhpInfoCollector;
use Guanguans\LaravelExceptionNotify\Collectors\RequestBasicCollector;
use Guanguans\LaravelExceptionNotify\Collectors\RequestCookieCollector;
use Guanguans\LaravelExceptionNotify\Collectors\RequestFileCollector;
use Guanguans\LaravelExceptionNotify\Collectors\RequestHeaderCollector;
use Guanguans\LaravelExceptionNotify\Collectors\RequestMiddlewareCollector;
use Guanguans\LaravelExceptionNotify\Collectors\RequestPostCollector;
use Guanguans\LaravelExceptionNotify\Collectors\RequestQueryCollector;
use Guanguans\LaravelExceptionNotify\Collectors\RequestRawFileCollector;
use Guanguans\LaravelExceptionNotify\Collectors\RequestServerCollector;
use Guanguans\LaravelExceptionNotify\Collectors\RequestSessionCollector;
use Guanguans\LaravelExceptionNotify\ExceptionNotifyServiceProvider;
use Guanguans\LaravelExceptionNotify\Exceptions\RuntimeException;
use Guanguans\LaravelExceptionNotify\Facades\ExceptionNotify;
use Guanguans\LaravelExceptionNotify\Pipes\AddKeywordPipe;
use Guanguans\LaravelExceptionNotify\Pipes\FixPrettyJsonPipe;
use Guanguans\LaravelExceptionNotify\Pipes\LimitLengthPipe;
use Guanguans\LaravelExceptionNotify\Pipes\ReplaceStrPipe;
use Guanguans\LaravelExceptionNotify\Pipes\SprintfHtmlPipe;
use Guanguans\LaravelExceptionNotify\Pipes\SprintfMarkdownPipe;
use Guanguans\Notify\Foundation\Client;
use GuzzleHttp\Psr7\HttpFactory;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Symfony\Component\VarDumper\Test\VarDumperTestTrait;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use MockeryPHPUnitIntegration;
    use VarDumperTestTrait;
    use Faker;

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
        ];
    }

    protected function defineEnvironment($app): void
    {
        config()->set('exception-notify.job.queue', 'exception-notify');
        config()->set('exception-notify.channels.bark.authenticator.token', $this->faker()->uuid());
        config()->set('exception-notify.channels.bark.client.http_options', []);
        config()->set('exception-notify.channels.bark.client.extender', static fn (Client $client): Client => $client->mock([
            (new HttpFactory)->createResponse(200, '{"code":200,"message":"success","timestamp":1708331409}'),
        ]));
        config()->set('exception-notify.collectors', [
            ApplicationCollector::class,
            ChoreCollector::class,
            ExceptionBasicCollector::class,
            ExceptionContextCollector::class,
            ExceptionTraceCollector::class,
            PhpInfoCollector::class,
            RequestBasicCollector::class,
            RequestCookieCollector::class,
            RequestFileCollector::class,
            RequestHeaderCollector::class,
            RequestMiddlewareCollector::class,
            RequestPostCollector::class,
            RequestQueryCollector::class,
            RequestRawFileCollector::class,
            RequestServerCollector::class,
            RequestSessionCollector::class,
        ]);
        config()->set('exception-notify.channels.log.pipes', [
            hydrate_pipe(AddKeywordPipe::class, 'keyword'),
            SprintfHtmlPipe::class,
            SprintfMarkdownPipe::class,
            FixPrettyJsonPipe::class,
            hydrate_pipe(LimitLengthPipe::class, 512),
            hydrate_pipe(ReplaceStrPipe::class, '.php', '.PHP'),
        ]);
    }

    protected function defineRoutes($router): void
    {
        $router->any('report-exception', static fn () => tap(response('report-exception'), static function (): void {
            ExceptionNotify::report(new RuntimeException('What happened?'), ['dump', 'log', 'bark', 'lark']);
        }));

        $router->any('exception', static fn () => tap(response('exception'), static function (): void {
            throw new RuntimeException('What happened?');
        }));
    }
}
