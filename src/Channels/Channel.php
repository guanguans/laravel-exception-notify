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

namespace Guanguans\LaravelExceptionNotify\Channels;

use Guanguans\LaravelExceptionNotify\Events\ExceptionReportedEvent;
use Guanguans\LaravelExceptionNotify\Events\ExceptionReportFailedEvent;
use Guanguans\LaravelExceptionNotify\Events\ExceptionReportingEvent;
use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

/**
 * @see \Illuminate\Log\Logger
 * @see \Illuminate\Log\LogManager::createEmergencyLogger()
 * @see \Illuminate\Log\LogManager::get()
 * @see \Illuminate\Log\LogManager::stack()
 */
class Channel implements \Guanguans\LaravelExceptionNotify\Contracts\Channel
{
    private static array $skipCallbacks = [];

    public function __construct(
        private \Guanguans\LaravelExceptionNotify\Contracts\Channel $channel
    ) {}

    public function report(\Throwable $throwable): void
    {
        try {
            if ($this->shouldntReport($throwable)) {
                return;
            }

            $this->channel->report($throwable);
        } catch (\Throwable $throwable) {
            Log::error($throwable->getMessage(), ['exception' => $throwable]);
        }
    }

    public function reportRaw(string $report): mixed
    {
        try {
            Event::dispatch(new ExceptionReportingEvent($this->channel, $report));

            $result = $this->channel->reportRaw($report);

            Event::dispatch(new ExceptionReportedEvent($this->channel, $result));

            return $result;
        } catch (\Throwable $throwable) {
            Log::error($throwable->getMessage(), ['exception' => $throwable]);

            Event::dispatch(new ExceptionReportFailedEvent($this->channel, $throwable));

            return $throwable;
        }
    }

    public function reporting(mixed $listener): void
    {
        Event::listen(ExceptionReportingEvent::class, $listener);
    }

    public function reported(mixed $listener): void
    {
        Event::listen(ExceptionReportedEvent::class, $listener);
    }

    public function reportFailed(mixed $listener): void
    {
        Event::listen(ExceptionReportFailedEvent::class, $listener);
    }

    public static function skipWhen(\Closure $callback): void
    {
        self::$skipCallbacks[] = $callback;
    }

    public function shouldReport(\Throwable $throwable): bool
    {
        return !$this->shouldntReport($throwable);
    }

    /**
     * @noinspection IfSimplificationOrInspection
     */
    private function shouldntReport(\Throwable $throwable): bool
    {
        if (!config('exception-notify.enabled')) {
            return true;
        }

        if (!app()->environment(config('exception-notify.environments'))) {
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
