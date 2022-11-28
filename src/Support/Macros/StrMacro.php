<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Support\Macros;

/**
 * @mixin \Illuminate\Support\Str
 */
class StrMacro
{
    public static function beforeLast(): callable
    {
        return static function ($subject, $search) {
            if ('' === $search) {
                return $subject;
            }
            $pos = mb_strrpos($subject, $search);
            if (false === $pos) {
                return $subject;
            }

            return static::substr($subject, 0, $pos);
        };
    }

    public static function lcfirst(): callable
    {
        return static function ($string): string {
            return lcfirst($string);
        };
    }

    public static function ucwords(): callable
    {
        return static function ($string): string {
            return ucwords($string);
        };
    }
}
