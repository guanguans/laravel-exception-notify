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

use Guanguans\LaravelExceptionNotify\ExceptionNotifyServiceProvider;
use Guanguans\LaravelExceptionNotify\Facades\ExceptionNotify;
use Illuminate\Support\Facades\Route;
use Spatie\Snapshots\MatchesSnapshots;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use MatchesSnapshots;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpApplicationRoutes();
    }

    protected function getPackageProviders($app)
    {
        return [
            ExceptionNotifyServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('exception-notify', require __DIR__.'/../config/exception-notify.php');
        $app['config']->set('exception-notify.enabled', true);
        $app['config']->set('exception-notify.channels.bark.token', 'GQpdjXqYuCrQDWpW');
        $app['config']->set('exception-notify.channels.log.channel', 'single');
        $app['config']->set('exception-notify.channels.mail.dsn', 'smtp://53xxx11@qq.com:kixxxxxxxxgg@smtp.qq.com:465?verify_peer=0');
        $app['config']->set('exception-notify.channels.mail.from', '53xxx11@qq.com');
        $app['config']->set('exception-notify.channels.mail.to', '53xxx11@qq.com');
        $app['config']->set('exception-notify.rate_limiter.config.limit', 1000);
        $app['config']->set('exception-notify.collector', [
            \Guanguans\LaravelExceptionNotify\Collectors\LaravelCollector::class,
            \Guanguans\LaravelExceptionNotify\Collectors\AdditionCollector::class,
            \Guanguans\LaravelExceptionNotify\Collectors\PhpInfoCollector::class,
            \Guanguans\LaravelExceptionNotify\Collectors\ExceptionBasicCollector::class,
            \Guanguans\LaravelExceptionNotify\Collectors\ExceptionTraceCollector::class,
            \Guanguans\LaravelExceptionNotify\Collectors\RequestBasicCollector::class,
            \Guanguans\LaravelExceptionNotify\Collectors\RequestHeaderCollector::class,
            \Guanguans\LaravelExceptionNotify\Collectors\RequestQueryCollector::class,
            \Guanguans\LaravelExceptionNotify\Collectors\RequestPostCollector::class,
            \Guanguans\LaravelExceptionNotify\Collectors\RequestFileCollector::class,
            \Guanguans\LaravelExceptionNotify\Collectors\RequestMiddlewareCollector::class,
            \Guanguans\LaravelExceptionNotify\Collectors\RequestServerCollector::class,
            \Guanguans\LaravelExceptionNotify\Collectors\RequestCookieCollector::class,
            \Guanguans\LaravelExceptionNotify\Collectors\RequestSessionCollector::class,
        ]);

        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $app['config']->set('app.key', 'base64:6Cu/ozj4gPtIjmXjr8EdVnGFNsdRqZfHfVjQkmTlg4Y=');
    }

    protected function setUpApplicationRoutes(): void
    {
        Route::get('/report-exception', function () {
            ExceptionNotify::onChannel('dump', 'log')->report(new \Exception('What happened?'));

            return 'This is a test page.';
        });
    }

    public function tearDown(): void
    {
        parent::tearDown();
        if ($container = \Mockery::getContainer()) {
            $this->addToAssertionCount($container->Mockery_getExpectationCount());
        }
        \Mockery::close();
    }
}
