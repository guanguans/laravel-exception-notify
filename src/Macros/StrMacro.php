<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Macros;

/**
 * @mixin \Illuminate\Support\Str
 */
class StrMacro
{
    public static function lcfirst(): callable
    {
        return static fn ($string): string => lcfirst($string);
    }

    public static function ucwords(): callable
    {
        return static fn ($string): string => ucwords($string);
    }
}
