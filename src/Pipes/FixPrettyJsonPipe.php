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

namespace Guanguans\LaravelExceptionNotify\Pipes;

use Guanguans\LaravelExceptionNotify\Support\JsonFixer;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class FixPrettyJsonPipe
{
    private JsonFixer $jsonFixer;

    public function __construct(JsonFixer $jsonFixer)
    {
        $this->jsonFixer = $jsonFixer;
    }

    public function handle(Collection $collectors, \Closure $next, string $missingValue = '"..."'): Stringable
    {
        $report = $next($collectors);

        try {
            $fixedReport = $this
                ->jsonFixer
                ->silent(false)
                ->missingValue($missingValue)
                ->fix((string) $report);

            return Str::of(json_pretty_encode(json_decode($fixedReport, true, 512, \JSON_THROW_ON_ERROR)));
        } catch (\Throwable $throwable) {
            return $report;
        }
    }
}
