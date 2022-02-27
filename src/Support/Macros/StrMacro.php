<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Support\Macros;

class StrMacro
{
    public static function beforeLast(): callable
    {
        return function ($subject, $search) {
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
        return function ($string) {
            return lcfirst($string);
        };
    }
}
