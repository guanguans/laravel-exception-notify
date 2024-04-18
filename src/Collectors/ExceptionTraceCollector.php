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

namespace Guanguans\LaravelExceptionNotify\Collectors;

use Illuminate\Support\Str;

class ExceptionTraceCollector extends ExceptionCollector
{
    public function collect(): array
    {
        return collect(explode(\PHP_EOL, $this->exception->getTraceAsString()))
            ->filter(static fn ($trace): bool => !Str::contains($trace, 'vendor'))
            ->all();
    }
}
