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
 * @method static \Guanguans\LaravelExceptionNotify\ExceptionNotifyManager onChannel(...$channels)
 * @method static void                                                     report(\Throwable $throwable)
 * @method static void                                                     reportIf($condition, \Throwable $throwable)
 * @method static \Guanguans\LaravelExceptionNotify\ExceptionNotifyManager extend($driver, \Closure $callback)
 * @method static bool                                                     shouldReport(\Throwable $throwable)
 * @method static bool                                                     shouldntReport(\Throwable $throwable)
 * @method static void                                                     macro($name, $macro)
 * @method static void                                                     mixin($mixin, $replace = true)
 *
 * @see \Guanguans\LaravelExceptionNotify\ExceptionNotifyManager
 *
 * @mixin \Guanguans\LaravelExceptionNotify\ExceptionNotifyManager
 */
class ExceptionNotify extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'exception.notify';
    }
}
