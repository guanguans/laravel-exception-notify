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

use Illuminate\Support\Str;

class ExceptionTraceCollector extends AbstractExceptionCollector
{
    /** @var list<string> */
    private readonly array $except;

    /**
     * @param null|list<string> $except
     */
    public function __construct(?array $except = null)
    {
        $this->except = $except ?? ['vendor'];
    }

    public function collect(): array
    {
        return str($this->exception->getTraceAsString())
            ->explode(\PHP_EOL)
            ->reject(fn (string $trace): bool => str($trace)->contains($this->except))
            ->map(static fn (string $trace): string => Str::replaceFirst(base_path().\DIRECTORY_SEPARATOR, '', $trace))
            ->unique(static fn (string $trace, int $index): string => Str::replaceFirst("#$index ", '', $trace))
            ->all();
    }
}
