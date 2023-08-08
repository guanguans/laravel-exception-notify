<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
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
use Guanguans\LaravelExceptionNotify\Facades\ExceptionNotify;
use Illuminate\Support\Facades\Route;
use phpmock\phpunit\PHPMock;
use Symfony\Component\VarDumper\Test\VarDumperTestTrait;

/**
 * @internal
 *
 * @small
 */
class TestCase extends \Orchestra\Testbench\TestCase
{
    use PHPMock;
    use VarDumperTestTrait;

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        if ($container = \Mockery::getContainer()) {
            $this->addToAssertionCount($container->Mockery_getExpectationCount());
        }

        \Mockery::close();
    }

    protected function getPackageProviders($app)
    {
        return [
            ExceptionNotifyServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        config()->set('app.key', 'base64:6Cu/ozj4gPtIjmXjr8EdVnGFNsdRqZfHfVjQkmTlg4Y=');
        config()->set('exception-notify.job.queue', 'exception-notify');
        config()->set('exception-notify.channels.mail.dsn', 'smtp://53xxx11@qq.com:kixxxxxxxxgg@smtp.qq.com:465?verify_peer=0');
        config()->set('exception-notify.channels.mail.from', '53xxx11@qq.com');
        config()->set('exception-notify.channels.mail.to', '53xxx11@qq.com');
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
    }

    protected function defineRoutes($router): void
    {
        Route::any('report-exception', static fn () => tap(response('report-exception'), function (): void {
            ExceptionNotify::report(new \Exception('What happened?'), 'dump');
        }));
    }
}
