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

namespace Guanguans\LaravelExceptionNotify\Channels;

use Guanguans\LaravelExceptionNotify\Contracts\ChannelContract;
use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Facades\Cache;
use function Guanguans\LaravelExceptionNotify\Support\make;
use function Guanguans\LaravelExceptionNotify\Support\rescue;

/**
 * @see \Illuminate\Log\Logger
 * @see \Illuminate\Log\LogManager::createEmergencyLogger()
 * @see \Illuminate\Log\LogManager::get()
 * @see \Illuminate\Log\LogManager::stack()
 *
 * @api
 */
class Channel implements ChannelContract
{
    /** @var list<callable> */
    private static array $skipCallbacks = [];

    public function __construct(
        private readonly ChannelContract $channelContract
    ) {}

    /**
     * @api
     */
    public function report(\Throwable $throwable): void
    {
        rescue(function () use ($throwable): void {
            $this->shouldReport($throwable) and $this->channelContract->report($throwable);
        });
    }

    public function reportContent(string $content): mixed
    {
        return rescue(fn (): mixed => $this->channelContract->reportContent($content));
    }

    /**
     * @api
     */
    public static function skipWhen(\Closure $callback): void
    {
        self::$skipCallbacks[] = $callback;
    }

    /**
     * @api
     */
    public static function flush(): void
    {
        self::$skipCallbacks = [];
    }

    /**
     * @throws \ReflectionException
     */
    public function shouldReport(\Throwable $throwable): bool
    {
        return !$this->shouldntReport($throwable);
    }

    /**
     * @see \Illuminate\Foundation\Exceptions\Handler::shouldntReport()
     *
     * @throws \ReflectionException
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
     * @see RateLimiter::attempt()
     * @see \Illuminate\Cache\RateLimiting\Limit
     *
     * @throws \ReflectionException
     */
    private function attempt(\Throwable $throwable): bool
    {
        return $this->makeRateLimiter()->attempt(
            $this->fingerprintFor($throwable),
            config('exception-notify.rate_limiter.max_attempts'),
            static fn (): bool => true,
            config('exception-notify.rate_limiter.decay_seconds')
        );
    }

    /**
     * @throws \ReflectionException
     */
    private function makeRateLimiter(): RateLimiter
    {
        return make(config()->array('exception-notify.rate_limiter') + [
            'class' => RateLimiter::class,
            'cache' => Cache::store(config('exception-notify.rate_limiter.cache_store')),
        ]);
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
