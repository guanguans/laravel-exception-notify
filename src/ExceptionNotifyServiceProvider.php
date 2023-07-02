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

use Guanguans\LaravelExceptionNotify\Macros\CollectionMacro;
use Guanguans\LaravelExceptionNotify\Macros\RequestMacro;
use Guanguans\LaravelExceptionNotify\Macros\StringableMacro;
use Guanguans\LaravelExceptionNotify\Macros\StrMacro;
use Illuminate\Container\Container;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Laravel\Lumen\Application as LumenApplication;

class ExceptionNotifyServiceProvider extends ServiceProvider
{
    protected bool $defer = false;

    public function boot(): void
    {
        $this->setupConfig();
        Request::mixin($this->app->make(RequestMacro::class));
        Collection::mixin($this->app->make(CollectionMacro::class));
        Str::mixin($this->app->make(StrMacro::class));
        Stringable::mixin($this->app->make(StringableMacro::class));
    }

    public function register(): void
    {
        // Adapt lumen
        $this->setupConfig();
        $this->registerExceptionNotifyManager();
        $this->registerCollectorManager();
    }

    public function provides()
    {
        return [
            ExceptionNotifyManager::class,
            'exception.notify',
        ];
    }

    /**
     * Set up the config.
     *
     * @psalm-suppress UndefinedClass
     * @psalm-suppress UndefinedInterfaceMethod
     */
    protected function setupConfig(): void
    {
        /** @noinspection RealpathInStreamContextInspection */
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
        $this->app->singleton(CollectorManager::class, function (Container $container): CollectorManager {
            /** @var array<\Guanguans\LaravelExceptionNotify\Contracts\CollectorContract> $collection */
            $collection = collect($container['config']['exception-notify.collector'])
                ->map(function ($parameters, $class) {
                    if (! \is_array($parameters)) {
                        [$parameters, $class] = [$class, $parameters];
                    }

                    return $this->app->make($class, (array) $parameters);
                })
                ->values()
                ->all();

            return new CollectorManager($collection);
        });

        $this->app->alias(CollectorManager::class, 'exception.collector');
    }

    protected function registerExceptionNotifyManager(): void
    {
        $this->app->singleton(ExceptionNotifyManager::class, static fn ($app): ExceptionNotifyManager => new ExceptionNotifyManager($app));

        $this->app->alias(ExceptionNotifyManager::class, 'exception.notify');
    }
}
