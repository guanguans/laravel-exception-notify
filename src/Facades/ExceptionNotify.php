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

use Illuminate\Support\Facades\Facade;

/**
 * @method static void reportIf(void $condition, \Throwable $throwable)
 * @method static void report(\Throwable $throwable)
 * @method static bool shouldntReport(\Throwable $throwable)
 * @method static bool shouldReport(\Throwable $throwable)
 * @method static void getDefaultDriver()
 * @method static \Guanguans\LaravelExceptionNotify\ExceptionNotifyManager onChannel(void ...$channels)
 * @method static void getContainer()
 * @method static void setContainer(\Illuminate\Contracts\Container\Container $container)
 * @method static void forgetDrivers()
 * @method static mixed driver(null|string $driver = null)
 * @method static \Guanguans\LaravelExceptionNotify\ExceptionNotifyManager extend(string $driver, \Closure $callback)
 * @method static array getDrivers()
 * @method static void macro(string $name, callable|object $macro)
 * @method static void mixin(object $mixin, bool $replace = true)
 * @method static bool hasMacro(string $name)
 * @method static void flushMacros()
 * @method static mixed macroCall(string $method, array $parameters)
 *
 * @see \Guanguans\LaravelExceptionNotify\ExceptionNotifyManager
 */
class ExceptionNotify extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'exception.notify';
    }
}
