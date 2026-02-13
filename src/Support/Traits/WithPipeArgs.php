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

namespace Guanguans\LaravelExceptionNotify\Support\Traits;

trait WithPipeArgs
{
    public static function with(mixed ...$args): string
    {
        return [] === $args ? static::class : static::class.':'.implode(',', $args);
    }
}
