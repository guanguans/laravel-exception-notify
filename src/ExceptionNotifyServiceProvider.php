<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify;

use Guanguans\LaravelExceptionNotify\Events\ReportedEvent;
use Guanguans\LaravelExceptionNotify\Events\ReportingEvent;
use Guanguans\LaravelExceptionNotify\Support\Macros\CollectionMacro;
use Guanguans\LaravelExceptionNotify\Support\Macros\RequestMacro;
use Guanguans\LaravelExceptionNotify\Support\Macros\StrMacro;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
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
        Request::mixin($this->app->make(RequestMacro::class));
        Collection::mixin($this->app->make(CollectionMacro::class));
        Str::mixin($this->app->make(StrMacro::class));
        $this->registerReportingEvent();
        $this->registerReportedEvent();
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        // Adapt lumen
        $this->setupConfig();
        $this->registerExceptionNotifyManager();
        $this->registerCollectorManager();
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

    protected function registerCollectorManager()
    {
        $this->app->singleton(CollectorManager::class, function (Container $app) {
            $collectors = collect($app['config']['exception-notify.collector.class'])
                ->map(function ($parameters, $class) {
                    if (! is_array($parameters)) {
                        [$parameters, $class] = [$class, $parameters];
                    }

                    return $this->app->make($class, (array) $parameters);
                })
                ->values();

            return new CollectorManager($collectors);
        });

        $this->app->alias(CollectorManager::class, 'exception.collector');
    }

    protected function registerExceptionNotifyManager()
    {
        $this->app->singleton(ExceptionNotifyManager::class, function ($app) {
            return new ExceptionNotifyManager($app);
        });

        $this->app->alias(ExceptionNotifyManager::class, 'exception.notify');
        $this->app->alias(ExceptionNotifyManager::class, 'exception.notifier');
    }

    protected function registerReportingEvent()
    {
        foreach ($this->app['config']['exception-notify.reporting'] as $listener) {
            $this->app['events']->listen(ReportingEvent::class, $listener);
        }
    }

    protected function registerReportedEvent()
    {
        foreach ($this->app['config']['exception-notify.reported'] as $listener) {
            $this->app['events']->listen(ReportedEvent::class, $listener);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return [
            ExceptionNotifyManager::class,
            'exception.notifier',
        ];
    }
}
