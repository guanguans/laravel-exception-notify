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

use Guanguans\LaravelExceptionNotify\Contracts\ChannelContract;
use Guanguans\LaravelExceptionNotify\Events\ReportedEvent;
use Guanguans\LaravelExceptionNotify\Events\ReportingEvent;
use Guanguans\LaravelExceptionNotify\Support\Traits\AggregationTrait;
use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;

/**
 * @see \Illuminate\Log\Logger
 * @see \Illuminate\Log\LogManager::createEmergencyLogger()
 * @see \Illuminate\Log\LogManager::get()
 * @see \Illuminate\Log\LogManager::stack()
 */
class Channel implements ChannelContract
{
    use AggregationTrait;
    private static array $skipCallbacks = [];

    public function __construct(
        private ChannelContract $channelContract
    ) {}

    public function reportIf(mixed $condition, \Throwable $throwable): void
    {
        value($condition) and $this->report($throwable);
    }

    public function report(\Throwable $throwable): void
    {
        if ($this->shouldntReport($throwable)) {
            return;
        }

        $this->channelContract->report($throwable);
    }

    public function reportContent(string $content): mixed
    {
        Event::dispatch(new ReportingEvent($this->channelContract, $content));
        $result = $this->channelContract->reportContent($content);
        Event::dispatch(new ReportedEvent($this->channelContract, $result));

        return $result;
    }

    public function reporting(mixed $listener): void
    {
        Event::listen(ReportingEvent::class, $listener);
    }

    public function reported(mixed $listener): void
    {
        Event::listen(ReportedEvent::class, $listener);
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
     * @see \Illuminate\Foundation\Exceptions\Handler::shouldntReport()
     *
     * @noinspection NotOptimalIfConditionsInspection
     */
    private function shouldntReport(\Throwable $throwable): bool
    {
        if (
            !config('exception-notify.enabled')
            || !app()->environment(config('exception-notify.environments'))
            || $this->shouldSkip($throwable)
        ) {
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

    /**
     * @see \Illuminate\Foundation\Exceptions\Handler::shouldntReport()
     */
    private function fingerprintFor(\Throwable $throwable): string
    {
        return config('exception-notify.rate_limit.key_prefix').sha1(implode('|', [
            $throwable->getFile(),
            $throwable->getLine(),
            $throwable->getCode(),
        ]));
    }

    /**
     * @see RateLimiter::attempt
     */
    private function attempt(string $key, int $maxAttempts, int $decaySeconds = 60): bool
    {
        return (
            new RateLimiter(Cache::store(config('exception-notify.rate_limit.cache_store', config('cache.default'))))
        )->attempt($key, $maxAttempts, static fn (): bool => true, $decaySeconds);
    }
}
