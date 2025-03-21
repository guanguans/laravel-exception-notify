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
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Stringable;

class ExceptionNotifyServiceProvider extends ServiceProvider
{
    public array $singletons = [
        ExceptionNotifyManager::class,
        TestCommand::class,
    ];

    /**
     * @noinspection PhpMissingParentCallCommonInspection
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function register(): void
    {
        $this
            ->setupConfig()
            ->registerAliases()
            ->registerReportUsing();
    }

    public function boot(): void
    {
        $this->registerCommands();
    }

    /**
     * @noinspection PhpMissingParentCallCommonInspection
     */
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

    private function registerAliases(): self
    {
        foreach ($this->singletons as $singleton) {
            $this->alias($singleton);
        }

        return $this;
    }

    /**
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function registerReportUsing(): self
    {
        if (
            config('exception-notify.enabled')
            && method_exists($exceptionHandler = $this->app->make(ExceptionHandler::class), 'reportable')
        ) {
            $exceptionHandler->reportable(static function (\Throwable $throwable): void {
                ExceptionNotify::report($throwable);
            });
        }

        return $this;
    }

    private function registerCommands(): self
    {
        if ($this->app->runningInConsole()) {
            $this->commands(TestCommand::class);
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
            ->map(static fn (string $name): Stringable => str($name)->snake('-'))
            ->implode('.');
    }
}
