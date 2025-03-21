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

class ExceptionTraceCollector extends AbstractExceptionCollector
{
    private array $except;

    public function __construct(?array $except = null)
    {
        $this->except = $except ?? ['vendor'];
    }

    public function collect(): array
    {
        return collect(explode(\PHP_EOL, $this->exception->getTraceAsString()))
            ->reject(fn (string $trace): bool => str($trace)->contains($this->except))
            ->map(static fn (string $trace): string => (string) str($trace)->replaceFirst(base_path(), ''))
            ->all();
    }
}
