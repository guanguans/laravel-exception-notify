<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

namespace Guanguans\LaravelExceptionNotify;

use Composer\InstalledVersions;
use Guanguans\LaravelExceptionNotify\Commands\TestCommand;
use Guanguans\LaravelExceptionNotify\Facades\ExceptionNotify;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class ExceptionNotifyServiceProvider extends ServiceProvider /* implements DeferrableProvider */
{
    /**
     * @api
     *
     * @var array<array-key, string>
     *
     * @noinspection ClassOverridesFieldOfSuperClassInspection
     */
    public array $singletons = [
        ExceptionNotifyManager::class,
    ];

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @noinspection PhpMissingParentCallCommonInspection
     */
    public function register(): void
    {
        $this->setupConfig();
        $this->registerReportUsing();
    }

    /**
     * @api
     */
    public function boot(): void
    {
        $this->registerCommands();
    }

    /**
     * @return list<string>
     *
     * @noinspection PhpMissingParentCallCommonInspection
     */
    public function provides(): array
    {
        return [
            ExceptionNotifyManager::class,
        ];
    }

    private function setupConfig(): void
    {
        /** @noinspection RealpathInStreamContextInspection */
        $source = realpath($raw = __DIR__.'/../config/exception-notify.php') ?: $raw;

        if ($this->app->runningInConsole()) {
            $this->publishes([$source => config_path('exception-notify.php')], 'laravel-exception-notify');
        }

        $this->mergeConfigFrom($source, 'exception-notify');
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     */
    private function registerReportUsing(): void
    {
        if (
            config('exception-notify.enabled')
            && method_exists($exceptionHandler = $this->app->make(ExceptionHandler::class), 'reportable')
        ) {
            $exceptionHandler->reportable(static function (\Throwable $throwable): void {
                ExceptionNotify::report($throwable);
            });
        }
    }

    private function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands(TestCommand::class);
            $this->addSectionToAboutCommand();
        }
    }

    private function addSectionToAboutCommand(): void
    {
        AboutCommand::add(
            str($package = 'guanguans/laravel-exception-notify')->headline()->toString(),
            static fn (): array => collect(['Homepage' => "https://github.com/$package"])
                ->when(
                    class_exists(InstalledVersions::class),
                    static fn (Collection $data): Collection => $data->put(
                        'Version',
                        InstalledVersions::getPrettyVersion($package)
                    )
                )
                ->all()
        );
    }
}
