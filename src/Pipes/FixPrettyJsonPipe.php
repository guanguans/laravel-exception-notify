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

namespace Guanguans\LaravelExceptionNotify\Pipes;

use Guanguans\LaravelExceptionNotify\Support\JsonFixer;
use Guanguans\LaravelExceptionNotify\Support\Traits\WithPipeArgs;
use Illuminate\Support\Collection;
use Illuminate\Support\Stringable;
use function Guanguans\LaravelExceptionNotify\Support\json_pretty_encode;

class FixPrettyJsonPipe
{
    use WithPipeArgs;

    public function __construct(private readonly JsonFixer $jsonFixer) {}

    public function handle(Collection $collectors, \Closure $next, string $missingValue = '"..."'): Stringable
    {
        $content = $next($collectors);

        try {
            $fixedReport = $this
                ->jsonFixer
                ->silent(false)
                ->missingValue($missingValue)
                ->fix((string) $content);

            return str(json_pretty_encode(json_decode($fixedReport, true, 512, \JSON_THROW_ON_ERROR)));
        } catch (\Throwable) {
            return $content;
        }
    }
}
