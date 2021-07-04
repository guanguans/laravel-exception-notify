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
 * @method static report(\Throwable $exception)
 * @method static shouldReport(\Throwable $exception)
 * @method static shouldntReport(\Throwable $exception)
 *
 * @see \Guanguans\LaravelExceptionNotify\Notifier
 */
class Notifier extends Facade
{
    /**
     * {@inheritdoc}
     */
    public static function getFacadeAccessor()
    {
        return 'exception.notifier';
    }
}
