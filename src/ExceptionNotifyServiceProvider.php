<?php

declare(strict_types=1);

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
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\RateLimiter\Storage\CacheStorage;

class ExceptionNotifyServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = false;

    public function boot(): void
    {
        $this->setupConfig();
        Request::mixin($this->app->make(RequestMacro::class));
        Collection::mixin($this->app->make(CollectionMacro::class));
        Str::mixin($this->app->make(StrMacro::class));
        // $this->registerReportingEvent();
        // $this->registerReportedEvent();
    }

    /**
     * {@inheritdoc}
     */
    public function register(): void
    {
        // Adapt lumen
        $this->setupConfig();
        $this->registerExceptionNotifyManager();
        $this->registerCollectorManager();
        $this->registerRateLimiter();
    }

    /**
     * Set up the config.
     */
    protected function setupConfig(): void
    {
        $source = realpath($raw = __DIR__.'/../config/exception-notify.php') ?: $raw;

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('exception-notify.php')], 'laravel-exception-notify');
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('exception-notify');
        }

        $this->mergeConfigFrom($source, 'exception-notify');
    }

    protected function registerCollectorManager(): void
    {
        $this->app->singleton(CollectorManager::class, function (Container $app) {
            $collectors = collect($app['config']['exception-notify.collector'])
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

    protected function registerExceptionNotifyManager(): void
    {
        $this->app->singleton(ExceptionNotifyManager::class, fn ($app) => new ExceptionNotifyManager($app));

        $this->app->alias(ExceptionNotifyManager::class, 'exception.notify');
        $this->app->alias(ExceptionNotifyManager::class, 'exception.notifier');
    }

    protected function registerRateLimiter(): void
    {
        $this->app->singleton(CacheStorage::class, function (Container $app) {
            return new CacheStorage(
                $app->make(
                    $app['config']['exception-notify.rate_limiter.storage.class'],
                    $app['config']['exception-notify.rate_limiter.storage.parameters']
                )
            );
        });
        $this->app->alias(CacheStorage::class, 'exception.rate-limiter.storage');

        $this->app->singleton(RateLimiterFactory::class, function (Container $app) {
            return new RateLimiterFactory(
                array_merge([
                    'id' => 'exception-notify',
                    'policy' => 'token_bucket',
                    'limit' => 6,
                    'interval' => '1 minutes',
                    'rate' => [
                        'amount' => 1,
                        'interval' => '1 minutes',
                    ],
                ], $app['config']['exception-notify.rate_limiter.config']),
                $this->app->make(CacheStorage::class)
            );
        });
        $this->app->alias(RateLimiterFactory::class, 'exception.rate-limiter.factory');
    }

    protected function registerReportingEvent(): void
    {
        foreach ($this->app['config']['exception-notify.reporting'] as $listener) {
            $this->app['events']->listen(ReportingEvent::class, $listener);
        }
    }

    protected function registerReportedEvent(): void
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
