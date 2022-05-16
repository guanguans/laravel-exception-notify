<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Tests;

use Exception;
use Guanguans\LaravelExceptionNotify\Facades\ExceptionNotify;
use Illuminate\Support\Facades\Route;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpApplicationRoutes();
    }

    protected function getPackageProviders($app)
    {
        return [
            \Guanguans\LaravelExceptionNotify\ExceptionNotifyServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('soar', require __DIR__.'/../config/exception-notify.php');
        $app['config']->set('soar.enabled', true);

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
            ExceptionNotify::onChannel('dump', 'log')->report(new Exception('What happened?'));

            return 'This is a test page.';
        });
    }
}
