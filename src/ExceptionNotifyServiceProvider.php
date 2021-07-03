<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify;

use Illuminate\Support\ServiceProvider;

class ExceptionNotifyServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = false;

    public function boot()
    {
    }

    public function register()
    {
        $this->setupConfig();

        $this->app->singleton('exception.notifier', function ($app) {
            return new Notifier(config('exception-notify'));
        });
    }

    /**
     * Setup the config.
     */
    protected function setupConfig()
    {
        $source = __DIR__.'/../config/exception-notify.php';

        if ($this->app->runningInConsole()) {
            $this->publishes([$source => config_path('exception-notify.php')], 'exception-notify');
        }

        $this->mergeConfigFrom($source, 'exception-notify');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['exception.notifier'];
    }
}
