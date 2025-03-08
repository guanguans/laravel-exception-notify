<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

namespace Guanguans\LaravelExceptionNotify;

use Guanguans\LaravelExceptionNotify\Commands\TestCommand;
use Guanguans\LaravelExceptionNotify\Facades\ExceptionNotify;
use Illuminate\Container\Container;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class ExceptionNotifyServiceProvider extends ServiceProvider
{
    public array $singletons = [];

    public function register(): void
    {
        $this->setupConfig()
            // ->registerMacros()
            ->registerExceptionNotifyManager()
            ->registerTestCommand();
    }

    public function boot(): void
    {
        $this->registerReportUsing()
            ->registerCommands();
    }

    public function provides(): array
    {
        return [
            $this->toAlias(ExceptionNotifyManager::class),
            $this->toAlias(TestCommand::class),
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

    private function registerExceptionNotifyManager(): self
    {
        $this->app->singleton(
            ExceptionNotifyManager::class,
            static fn (Container $container): ExceptionNotifyManager => new ExceptionNotifyManager($container)
        );

        $this->alias(ExceptionNotifyManager::class);

        return $this;
    }

    private function registerTestCommand(): self
    {
        $this->app->singleton(TestCommand::class);
        $this->alias(TestCommand::class);

        return $this;
    }

    /**
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function registerReportUsing(): self
    {
        if (method_exists($exceptionHandler = $this->app->make(ExceptionHandler::class), 'reportable')) {
            $exceptionHandler->reportable(static function (\Throwable $throwable): void {
                ExceptionNotify::report($throwable);
            });
        }

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
