<?php

/** @noinspection PhpUnused */
/** @noinspection PhpUnusedPrivateMethodInspection */

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

use Guanguans\LaravelExceptionNotify\Contracts\Channel;
use Guanguans\LaravelExceptionNotify\Exceptions\InvalidArgumentException;
use Illuminate\Cache\RateLimiter;
use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Manager;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Tappable;

/**
 * @property \Illuminate\Foundation\Application $container
 *
 * @method Channel driver($driver = null)
 */
class ExceptionNotifyManager extends Manager implements Channel
{
    use Macroable {
        Macroable::__call as macroCall;
    }
    use Tappable;
    private static array $skipCallbacks = [];

    /**
     * @noinspection MissingReturnTypeInspection
     */
    public function __call(mixed $method, mixed $parameters)
    {
        if (static::hasMacro($method)) {
            return $this->macroCall($method, $parameters);
        }

        return parent::__call($method, $parameters);
    }

    public static function skipWhen(\Closure $callback): void
    {
        self::$skipCallbacks[] = $callback;
    }

    public function channel(?string $channel = null): Channel
    {
        return $this->driver($channel);
    }

    public function reportIf(mixed $condition, \Throwable $throwable): void
    {
        value($condition) and $this->report($throwable);
    }

    public function report(\Throwable $throwable): void
    {
        $this->driver()->report($throwable);
    }

    public function reportRaw(string $report): mixed
    {
        return $this->driver()->reportRaw($report);
    }

    public function getDefaultDriver(): string
    {
        return config('exception-notify.default');
    }

    public function shouldReport(\Throwable $throwable): bool
    {
        return !$this->shouldntReport($throwable);
    }

    /**
     * @noinspection MissingParentCallInspection
     * @noinspection MethodVisibilityInspection
     */
    protected function createDriver(mixed $driver): Channel
    {
        if (isset($this->customCreators[$driver])) {
            return $this->callCustomCreator($driver);
        }

        $configRepository = new Repository($this->config->get("exception-notify.channels.$driver", []));
        $configRepository->set('__channel', $driver);

        $studlyName = Str::studly($configRepository->get('driver', $driver));

        // if (method_exists($this, $method = "create{$studlyName}Driver")) {
        //     return $this->{$method}($configRepository);
        // }

        if (class_exists($class = "\\Guanguans\\LaravelExceptionNotify\\Channels\\{$studlyName}Channel")) {
            return new $class($configRepository);
        }

        throw new InvalidArgumentException("Driver [$driver] not supported.");
    }

    /**
     * @noinspection IfSimplificationOrInspection
     */
    private function shouldntReport(\Throwable $throwable): bool
    {
        if (!config('exception-notify.enabled')) {
            return true;
        }

        if (!$this->container->environment(config('exception-notify.envs'))) {
            return true;
        }

        if ($this->shouldSkip($throwable)) {
            return true;
        }

        return !$this->attempt(
            $this->fingerprintFor($throwable),
            config('exception-notify.rate_limit.max_attempts'),
            config('exception-notify.rate_limit.decay_seconds')
        );
    }

    private function shouldSkip(\Throwable $throwable): bool
    {
        foreach (self::$skipCallbacks as $skipCallback) {
            if ($skipCallback($throwable)) {
                return true;
            }
        }

        return false;
    }

    private function fingerprintFor(\Throwable $throwable): string
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
    private function attempt(string $key, int $maxAttempts, int $decaySeconds = 60): bool
    {
        return (
            new RateLimiter(Cache::store(config('exception-notify.rate_limit.cache_store')))
        )->attempt($key, $maxAttempts, static fn (): bool => true, $decaySeconds);
    }
}
