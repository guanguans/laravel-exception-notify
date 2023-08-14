<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Collectors;

use Illuminate\Support\Str;

class ExceptionTraceCollector extends ExceptionCollector
{
    public function collect(): array
    {
        return collect(explode(PHP_EOL, $this->exception->getTraceAsString()))
            ->filter(static fn ($trace): bool => ! Str::contains($trace, 'vendor'))
            ->all();
    }
}
