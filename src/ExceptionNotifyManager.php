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

use Guanguans\LaravelExceptionNotify\Contracts\Channel;
use Guanguans\LaravelExceptionNotify\Jobs\ReportExceptionJob;
use Illuminate\Cache\RateLimiter;
use Illuminate\Config\Repository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Manager;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Tappable;

/**
 * @property \Illuminate\Foundation\Application $container
 *
 * @method \Guanguans\LaravelExceptionNotify\Contracts\Channel driver($driver = null)
 *
 * @mixin \Guanguans\LaravelExceptionNotify\Contracts\Channel
 */
class ExceptionNotifyManager extends Manager
{
    use Macroable {
        Macroable::__call as macroCall;
    }
    use Tappable;

    /**
     * Handle dynamic method calls into the method.
     *
     * @param mixed $method
     * @param mixed $parameters
     */
    public function __call($method, $parameters)
    {
        if (static::hasMacro($method)) {
            return $this->macroCall($method, $parameters);
        }

        return parent::__call($method, $parameters);
    }

    /**
     * @param mixed $condition
     * @param list<string>|string $channels
     */
    public function reportIf($condition, \Throwable $throwable, $channels = null): void
    {
        value($condition) and $this->report($throwable, $channels);
    }

    /**
     * @param list<string>|string $channels
     */
    public function report(\Throwable $throwable, $channels = null): void
    {
        try {
            if ($this->shouldntReport($throwable)) {
                return;
            }

            $dispatch = dispatch(new ReportExceptionJob(
                app(CollectorManager::class)->mapToReports(
                    (array) ($channels ?? config('exception-notify.defaults')),
                    $throwable
                )
            ));

            if (
                !$this->container->runningInConsole()
                && 'sync' === config('exception-notify.job.connection')
                && method_exists($dispatch, 'afterResponse')
            ) {
                $dispatch->afterResponse();
            }

            unset($dispatch);
        } catch (\Throwable $throwable) {
            // report($throwable);
            Log::error($throwable->getMessage(), ['exception' => $throwable]);
        }
    }

    public function getDefaultDriver(): string
    {
        return Arr::first((array) config('exception-notify.defaults'));
    }

    public function shouldReport(\Throwable $throwable): bool
    {
        return !$this->shouldntReport($throwable);
    }

    protected function shouldntReport(\Throwable $throwable): bool
    {
        if (!config('exception-notify.enabled')) {
            return true;
        }

        if (!Str::is(config('exception-notify.env'), (string) $this->container->environment())) {
            return true;
        }

        if (Arr::first(config('exception-notify.except'), static fn (string $type): bool => $throwable instanceof $type)) {
            return true;
        }

        return !$this->attempt(
            $this->toFingerprint($throwable),
            config('exception-notify.rate_limit.max_attempts'),
            config('exception-notify.rate_limit.decay_seconds')
        );
    }

    protected function toFingerprint(\Throwable $throwable): string
    {
        return config('exception-notify.rate_limit.key_prefix').sha1(implode('|', [
            $throwable->getFile(),
            $throwable->getLine(),
            $throwable->getCode(),
            $throwable->getTraceAsString(),
        ]));
    }

    /**
     * @see RateLimiter::attempt
     */
    protected function attempt(string $key, int $maxAttempts, int $decaySeconds = 60): bool
    {
        if (app(RateLimiter::class)->tooManyAttempts($key, $maxAttempts)) {
            return false;
        }

        return tap(true, static function () use ($key, $decaySeconds): void {
            app(RateLimiter::class)->hit($key, $decaySeconds);
        });
    }

    protected function createDriver($driver)
    {
        if (isset($this->customCreators[$driver])) {
            return $this->callCustomCreator($driver);
        }

        $configRepository = new Repository($this->config->get("exception-notify.channels.$driver", []));

        $studlyName = Str::studly($configRepository->get('driver', $driver));

        if (method_exists($this, $method = "create{$studlyName}Driver")) {
            return $this->{$method}($configRepository);
        }

        if (class_exists($class = "Guanguans\\LaravelExceptionNotify\\Channels\\{$studlyName}Channel")) {
            return new $class($configRepository);
        }

        throw new \InvalidArgumentException("Driver [$driver] not supported.");
    }

    /**
     * @noinspection PhpUnusedParameterInspection
     */
    private function createDumpDriver(): Channel
    {
        return new class implements Channel {
            /**
             * @noinspection ForgottenDebugOutputInspection
             * @noinspection DebugFunctionUsageInspection
             */
            public function report(string $report): string
            {
                return dump($report);
            }
        };
    }
}
