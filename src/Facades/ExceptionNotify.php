<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Facades;

use Guanguans\LaravelExceptionNotify\ExceptionNotifyManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void reportIf(mixed $condition, \Throwable $throwable, array|string $channels = null)
 * @method static void report(\Throwable $throwable, array|string $channels = null)
 * @method static void getDefaultDriver()
 * @method static bool shouldReport(\Throwable $throwable)
 * @method static mixed driver(null|string $driver = null)
 * @method static \Guanguans\LaravelExceptionNotify\ExceptionNotifyManager extend(string $driver, \Closure $callback)
 * @method static array getDrivers()
 * @method static \Illuminate\Contracts\Container\Container getContainer()
 * @method static \Guanguans\LaravelExceptionNotify\ExceptionNotifyManager setContainer(\Illuminate\Contracts\Container\Container $container)
 * @method static \Guanguans\LaravelExceptionNotify\ExceptionNotifyManager forgetDrivers()
 * @method static void macro(string $name, callable|object $macro)
 * @method static void mixin(object $mixin, bool $replace = true)
 * @method static bool hasMacro(string $name)
 * @method static void flushMacros()
 * @method static mixed macroCall(string $method, array $parameters)
 * @method static \Guanguans\LaravelExceptionNotify\ExceptionNotifyManager|\Illuminate\Support\HigherOrderTapProxy tap(null|callable $callback = null)
 *
 * @see \Guanguans\LaravelExceptionNotify\ExceptionNotifyManager
 */
class ExceptionNotify extends Facade
{
    /**
     * @noinspection MissingParentCallInspection
     * @noinspection PhpMissingParentCallCommonInspection
     */
    protected static function getFacadeAccessor(): string
    {
        return ExceptionNotifyManager::class;
    }
}
