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
        $app['config']->set('app.key', 'base64:6Cu/ozj4gPtIjmXjr8EdVnGFNsdRqZfHfVjQkmTlg4Y=');
        $app['config']->set('exception-notify.channels.mail.dsn', 'smtp://53xxx11@qq.com:kixxxxxxxxgg@smtp.qq.com:465?verify_peer=0');
        $app['config']->set('exception-notify.channels.mail.from', '53xxx11@qq.com');
        $app['config']->set('exception-notify.channels.mail.to', '53xxx11@qq.com');
    }

    protected function defineRoutes($router): void
    {
        Route::any('report-exception', static fn () => tap(response('report-exception'), function (): void {
            ExceptionNotify::report(new \Exception('What happened?'), 'dump');
        }));
    }
}
