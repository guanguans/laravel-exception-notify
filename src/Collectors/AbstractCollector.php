<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

namespace Guanguans\LaravelExceptionNotify\Collectors;

use Guanguans\LaravelExceptionNotify\Contracts\CollectorContract;

abstract class AbstractCollector implements CollectorContract
{
    public function name(): string
    {
        return static::fallbackName();
    }

    public static function fallbackName(): string
    {
        return ucwords((string) str(class_basename(static::class))
            ->beforeLast(str(class_basename(self::class))->remove('Abstract'))
            ->snake(' '));
    }
}
