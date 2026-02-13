<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

namespace Guanguans\LaravelExceptionNotify\Collectors;

use Guanguans\LaravelExceptionNotify\Contracts\CollectorContract;

/**
 * @see https://github.com/laravel/telescope/tree/5.x/src/Watchers
 * @see https://github.com/spatie/laravel-ray/tree/main/src/Watchers
 */
abstract class AbstractCollector implements CollectorContract
{
    public function name(): string
    {
        return static::fallbackName();
    }

    public static function fallbackName(): string
    {
        return str(class_basename(static::class))
            ->beforeLast('Collector')
            ->headline()
            ->toString();
    }
}
