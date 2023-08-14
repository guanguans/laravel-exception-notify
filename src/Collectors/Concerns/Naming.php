<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Collectors\Concerns;

use Illuminate\Support\Str;

/**
 * @mixin \Guanguans\LaravelExceptionNotify\Collectors\Collector
 */
trait Naming
{
    public static function name(): string
    {
        return (string) Str::of(class_basename(static::class))
            ->beforeLast(class_basename(self::class))
            ->snake(' ')
            ->ucwords();
    }
}
