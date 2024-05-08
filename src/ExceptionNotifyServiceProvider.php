<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

namespace Guanguans\LaravelExceptionNotify;

use Guanguans\LaravelExceptionNotify\Commands\TestCommand;
use Guanguans\LaravelExceptionNotify\Facades\ExceptionNotify;
use Guanguans\LaravelExceptionNotify\Macros\RequestMacro;
use Guanguans\LaravelExceptionNotify\Macros\StringableMacro;
use Guanguans\LaravelExceptionNotify\Macros\StrMacro;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Exceptions\Handler;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class ExceptionNotifyServiceProvider extends ServiceProvider
{
    public array $singletons = [
        RequestMacro::class => RequestMacro::class,
        StringableMacro::class => StringableMacro::class,
        StrMacro::class => StrMacro::class,
    ];

    /**
     * @throws \ReflectionException
     * @throws BindingResolutionException
     */
    public function register(): void
    {
        $this->setupConfig()
            ->registerMacros()
            ->registerExceptionNotifyManager()
            ->registerCollectorManager()
            ->registerTestCommand();
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
            $this->toAlias(TestCommand::class),
            CollectorManager::class,
            ExceptionNotifyManager::class,
            TestCommand::class,
        ];
    }

    private function setupConfig(): self
    {
        /** @noinspection RealpathInStreamContextInspection */
        $source = realpath($raw = __DIR__.'/../config/exception-notify.php') ?: $raw;

        if ($this->app->runningInConsole()) {
            $this->publishes([$source => config_path('exception-notify.php')], 'laravel-exception-notify');
        }

        $this->mergeConfigFrom($source, 'exception-notify');

        return $this;
    }

    /**
     * @throws \ReflectionException
     * @throws BindingResolutionException
     */
    private function registerMacros(): self
    {
        Request::mixin($this->app->make(RequestMacro::class));
        Str::mixin($this->app->make(StrMacro::class));
        Stringable::mixin($this->app->make(StringableMacro::class));

        return $this;
    }

    private function registerExceptionNotifyManager(): self
    {
        $this->app->singleton(
            ExceptionNotifyManager::class,
            static fn (Container $container): ExceptionNotifyManager => new ExceptionNotifyManager($container)
        );

        $this->alias(ExceptionNotifyManager::class);

        return $this;
    }

    private function registerCollectorManager(): self
    {
        $this->app->singleton(
            CollectorManager::class,
            static fn (Container $container): CollectorManager => new CollectorManager(
                collect(config('exception-notify.collectors', []))
                    ->map(static function ($parameters, $class) use ($container) {
                        if (!\is_array($parameters)) {
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

    private function registerTestCommand(): self
    {
        $this->app->singleton(TestCommand::class);
        $this->alias(TestCommand::class);

        return $this;
    }

    private function extendExceptionHandler(): self
    {
        $this->app->extend(ExceptionHandler::class, function (ExceptionHandler $exceptionHandler): ExceptionHandler {
            if ($reportUsingCreator = config('exception-notify.report_using_creator')) {
                /** @var callable(ExceptionHandler):callable|class-string $reportUsingCreator */
                if (\is_string($reportUsingCreator) && class_exists($reportUsingCreator)) {
                    $reportUsingCreator = $this->app->make($reportUsingCreator);
                }

                /** @var callable(\Throwable):mixed|void $reportUsing */
                $reportUsing = $reportUsingCreator($exceptionHandler);

                if ($reportUsing instanceof \Closure) {
                    $reportUsing = $reportUsing->bindTo($exceptionHandler, $exceptionHandler);
                }

                /** @var Handler $exceptionHandler */
                $exceptionHandler->reportable($reportUsing);
            }

            return $exceptionHandler;
        });

        return $this;
    }

    private function registerCommands(): self
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
    private function alias(string $class): self
    {
        $this->app->alias($class, $this->toAlias($class));

        return $this;
    }

    /**
     * @param class-string $class
     */
    private function toAlias(string $class): string
    {
        return str($class)
            ->replaceFirst(__NAMESPACE__, '')
            ->start('\\'.class_basename(ExceptionNotify::class))
            ->replaceFirst('\\', '')
            ->explode('\\')
            ->map(static fn (string $name): string => Str::snake($name, '-'))
            ->implode('.');
    }
}
