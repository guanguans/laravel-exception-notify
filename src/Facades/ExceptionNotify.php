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

namespace Guanguans\LaravelExceptionNotify\Facades;

use Guanguans\LaravelExceptionNotify\ExceptionNotifyManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed driver(string|null $driver = null)
 * @method static \Guanguans\LaravelExceptionNotify\ExceptionNotifyManager extend(string $driver, \Closure $callback)
 * @method static void flushMacros()
 * @method static \Guanguans\LaravelExceptionNotify\ExceptionNotifyManager forgetDrivers()
 * @method static \Illuminate\Contracts\Container\Container getContainer()
 * @method static string getDefaultDriver()
 * @method static array getDrivers()
 * @method static bool hasMacro(string $name)
 * @method static void macro(string $name, object|callable $macro)
 * @method static mixed macroCall(string $method, array $parameters)
 * @method static void mixin(object $mixin, bool $replace = true)
 * @method static void report(\Throwable $throwable, array|string $channels = null)
 * @method static void reportIf(mixed $condition, \Throwable $throwable, array|string $channels = null)
 * @method static \Guanguans\LaravelExceptionNotify\ExceptionNotifyManager setContainer(\Illuminate\Contracts\Container\Container $container)
 * @method static bool shouldReport(\Throwable $throwable)
 * @method static \Guanguans\LaravelExceptionNotify\ExceptionNotifyManager|\Illuminate\Support\HigherOrderTapProxy tap(callable|null $callback = null)
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
