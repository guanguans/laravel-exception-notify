<?php

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
 * @method static onChannel(...$channels)
 * @method static report(\Throwable $e)
 * @method static reportIf($condition, \Throwable $e)
 * @method static extend($driver, \Closure $callback)
 * @method static shouldReport(\Throwable $e)
 * @method static shouldntReport(\Throwable $e)
 * @method static macro($name, $macro)
 * @method static mixin($mixin, $replace = true)
 *
 * @see \Guanguans\LaravelExceptionNotify\ExceptionNotifyManager
 * @see \Guanguans\LaravelExceptionNotify\Channels\Channel
 */
class ExceptionNotify extends Facade
{
    /**
     * {@inheritdoc}
     */
    public static function getFacadeAccessor()
    {
        return 'exception.notify';
    }
}
