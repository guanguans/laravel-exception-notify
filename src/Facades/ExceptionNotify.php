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

namespace Guanguans\LaravelExceptionNotify\Facades;

use Guanguans\LaravelExceptionNotify\ExceptionNotifyManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Guanguans\LaravelExceptionNotify\Channels\Channel channel(string|null $channel = null)
 * @method static void reportIf(mixed $condition, \Throwable $throwable)
 * @method static void report(\Throwable $throwable)
 * @method static mixed reportRaw(string $content)
 * @method static string getDefaultDriver()
 * @method static mixed driver(string|null $driver = null)
 * @method static \Guanguans\LaravelExceptionNotify\ExceptionNotifyManager extend(string $driver, \Closure $callback)
 * @method static array getDrivers()
 * @method static \Illuminate\Contracts\Container\Container getContainer()
 * @method static \Guanguans\LaravelExceptionNotify\ExceptionNotifyManager setContainer(\Illuminate\Contracts\Container\Container $container)
 * @method static \Guanguans\LaravelExceptionNotify\ExceptionNotifyManager forgetDrivers()
 * @method static void macro(string $name, object|callable $macro)
 * @method static void mixin(object $mixin, bool $replace = true)
 * @method static bool hasMacro(string $name)
 * @method static void flushMacros()
 * @method static mixed macroCall(string $method, array $parameters)
 * @method static \Guanguans\LaravelExceptionNotify\ExceptionNotifyManager|\Illuminate\Support\HigherOrderTapProxy tap(callable|null $callback = null)
 * @method static void reporting(mixed $listener)
 * @method static void reported(mixed $listener)
 * @method static void reportFailed(mixed $listener)
 * @method static void skipWhen(\Closure $callback)
 * @method static bool shouldReport(\Throwable $throwable)
 *
 * @see \Guanguans\LaravelExceptionNotify\ExceptionNotifyManager
 */
class ExceptionNotify extends Facade
{
    /**
     * @noinspection PhpMissingParentCallCommonInspection
     */
    protected static function getFacadeAccessor(): string
    {
        return ExceptionNotifyManager::class;
    }
}
