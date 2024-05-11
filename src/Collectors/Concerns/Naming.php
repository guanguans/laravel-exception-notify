<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

namespace Guanguans\LaravelExceptionNotify\Collectors\Concerns;

/**
 * @mixin \Guanguans\LaravelExceptionNotify\Collectors\Collector
 */
trait Naming
{
    public static function name(): string
    {
        return ucwords(
            (string) str(class_basename(static::class))
                ->beforeLast(class_basename(self::class))
                ->snake(' ')
        );
    }
}
