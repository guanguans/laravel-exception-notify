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
use Guanguans\LaravelExceptionNotify\Support\Utils;
use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use function Guanguans\LaravelExceptionNotify\Support\make;
use function Guanguans\LaravelExceptionNotify\Support\rescue;

/**
 * @see \Illuminate\Log\Logger
 * @see \Illuminate\Log\LogManager::createEmergencyLogger()
 * @see \Illuminate\Log\LogManager::get()
 * @see \Illuminate\Log\LogManager::stack()
 */
class Channel implements ChannelContract
{
    use AggregationTrait;

    /** @var list<callable> */
    private static array $skipCallbacks = [];

    public function __construct(
        private ChannelContract $channelContract
    ) {}

    public function report(\Throwable $throwable): void
    {
        rescue(function () use ($throwable): void {
            if ($this->shouldntReport($throwable)) {
                return;
            }

            $this->channelContract->report($throwable);
        });
    }

    public function reportContent(string $content): mixed
    {
        return rescue(function () use ($content): mixed {
            Event::dispatch(new ReportingEvent($this->channelContract, $content));
            $result = $this->channelContract->reportContent($content);
            Event::dispatch(new ReportedEvent($this->channelContract, $result));

            return $result;
        });
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

    public static function flush(): void
    {
        self::$skipCallbacks = [];
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function shouldReport(\Throwable $throwable): bool
    {
        return !$this->shouldntReport($throwable);
    }

    /**
     * @see \Illuminate\Foundation\Exceptions\Handler::shouldntReport()
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function shouldntReport(\Throwable $throwable): bool
    {
        return !app()->environment(config('exception-notify.environments'))
            || $this->shouldSkip($throwable)
            || !$this->attempt($throwable);
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
     * @see \Illuminate\Cache\RateLimiting\Limit
     * @see RateLimiter::attempt()
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function attempt(\Throwable $throwable): bool
    {
        return Utils::applyConfigurationToObject(
            make($configuration = config('exception-notify.rate_limiter') + [
                'class' => RateLimiter::class,
                'cache' => Cache::store(config('exception-notify.rate_limiter.cache_store')),
            ]),
            $configuration
        )->attempt(
            $this->fingerprintFor($throwable),
            config('exception-notify.rate_limiter.max_attempts'),
            static fn (): bool => true,
            config('exception-notify.rate_limiter.decay_seconds')
        );
    }

    /**
     * @see \Illuminate\Foundation\Exceptions\Handler::shouldntReport()
     * @see \Illuminate\Foundation\Exceptions\Handler::throttle()
     * @see \Illuminate\Foundation\Exceptions\Handler::throttleUsing()
     */
    private function fingerprintFor(\Throwable $throwable): string
    {
        return config('exception-notify.rate_limiter.key_prefix').sha1(
            implode(':', [$throwable->getFile(), $throwable->getLine(), $throwable->getCode()])
        );
    }
}
