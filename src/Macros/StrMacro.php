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
        return static fn ($string): string => lcfirst($string);
    }

    public static function ucwords(): callable
    {
        return static fn ($string): string => ucwords($string);
    }

    public static function squish(): callable
    {
        return static fn ($value): string => preg_replace(
            '~(\s|\x{3164}|\x{1160})+~u',
            ' ',
            preg_replace('~^[\s\x{FEFF}]+|[\s\x{FEFF}]+$~u', '', $value)
        );
    }
}
