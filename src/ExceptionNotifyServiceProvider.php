<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify;

use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;

class ExceptionNotifyServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = false;

    public function boot()
    {
        $this->setupConfig();
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        // Adapt lumen
        $this->setupConfig();

        $this->app->singleton(Notifier::class, function ($app) {
            return new Notifier(config('exception-notify'));
        });

        $this->app->alias(Notifier::class, 'exception.notifier');
    }

    /**
     * Set up the config.
     */
    protected function setupConfig()
    {
        $source = realpath($raw = __DIR__.'/../config/exception-notify.php') ?: $raw;

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('exception-notify.php')], 'laravel-exception-notify');
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('exception-notify');
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
