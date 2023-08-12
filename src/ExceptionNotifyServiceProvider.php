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

use Guanguans\LaravelExceptionNotify\Commands\TestCommand;
use Guanguans\LaravelExceptionNotify\Macros\CollectionMacro;
use Guanguans\LaravelExceptionNotify\Macros\RequestMacro;
use Guanguans\LaravelExceptionNotify\Macros\StringableMacro;
use Guanguans\LaravelExceptionNotify\Macros\StrMacro;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Laravel\Lumen\Application as LumenApplication;

class ExceptionNotifyServiceProvider extends ServiceProvider
{
    public array $singletons = [
        CollectionMacro::class => CollectionMacro::class,
        RequestMacro::class => RequestMacro::class,
        StringableMacro::class => StringableMacro::class,
        StrMacro::class => StrMacro::class,
    ];

    protected bool $defer = false;

    /**
     * @throws \ReflectionException
     * @throws BindingResolutionException
     */
    public function register(): void
    {
        $this->setupConfig()
            ->registerMacros()
            ->registerExceptionNotifyManager()
            ->registerCollectorManager();
    }

    public function boot(): void
    {
        $this->extendExceptionHandler()
            ->registerCommands();
    }

    public function provides(): array
    {
        return [
            $this->toAlias(CollectorManager::class),
            $this->toAlias(ExceptionNotifyManager::class),
            CollectorManager::class,
            ExceptionNotifyManager::class,
        ];
    }

    protected function setupConfig(): self
    {
        /** @noinspection RealpathInStreamContextInspection */
        $source = realpath($raw = __DIR__.'/../config/exception-notify.php') ?: $raw;

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('exception-notify.php')], 'laravel-exception-notify');
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('exception-notify');
        }

        $this->mergeConfigFrom($source, 'exception-notify');

        return $this;
    }

    /**
     * @throws BindingResolutionException
     * @throws \ReflectionException
     */
    protected function registerMacros(): self
    {
        Collection::mixin($this->app->make(CollectionMacro::class));
        Request::mixin($this->app->make(RequestMacro::class));
        Str::mixin($this->app->make(StrMacro::class));
        Stringable::mixin($this->app->make(StringableMacro::class));

        return $this;
    }

    protected function registerExceptionNotifyManager(): self
    {
        $this->app->singleton(
            ExceptionNotifyManager::class,
            static fn (Container $container): ExceptionNotifyManager => new ExceptionNotifyManager($container)
        );

        $this->alias(ExceptionNotifyManager::class);

        return $this;
    }

    protected function registerCollectorManager(): self
    {
        $this->app->singleton(
            CollectorManager::class,
            static fn (Container $container): CollectorManager => new CollectorManager(
                collect(config('exception-notify.collectors', []))
                    ->map(static function ($parameters, $class) use ($container) {
                        if (! \is_array($parameters)) {
                            [$parameters, $class] = [(array) $class, $parameters];
                        }

                        return $container->make($class, $parameters);
                    })
                    ->all()
            )
        );

        $this->alias(CollectorManager::class);

        return $this;
    }

    protected function extendExceptionHandler(): self
    {
        $this->app->extend(ExceptionHandler::class, function (ExceptionHandler $handler): ExceptionHandler {
            if (method_exists($handler, 'reportable')) {
                $handler->reportable(function (\Throwable $e) use ($handler): void {
                    $this->app->make(ExceptionNotifyManager::class)->reportIf($handler->shouldReport($e), $e);
                });
            }

            return $handler;
        });

        return $this;
    }

    protected function registerCommands(): self
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                TestCommand::class,
            ]);
        }

        return $this;
    }

    /**
     * @param class-string $class
     */
    protected function alias(string $class, ?string $prefix = null): void
    {
        $this->app->alias($class, $this->toAlias($class, $prefix));
    }

    /**
     * @param class-string $class
     */
    protected function toAlias(string $class, ?string $prefix = null): string
    {
        $prefix ??= 'exception.notify.';

        $alias = Str::snake(class_basename($class), '.');
        if (Str::startsWith($alias, Str::replaceLast('.', '', $prefix))) {
            return $alias;
        }

        return $prefix.$alias;
    }
}
