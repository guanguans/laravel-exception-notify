<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Pipes;

use Guanguans\LaravelExceptionNotify\Support\JsonFixer;
use Illuminate\Support\Collection;
use Illuminate\Support\Stringable;

class FixPrettyJsonPipe
{
    protected JsonFixer $jsonFixer;

    public function __construct(JsonFixer $jsonFixer)
    {
        $this->jsonFixer = $jsonFixer;
    }

    public function handle(Collection $collectors, \Closure $next, string $missingValue = '"..."'): Stringable
    {
        try {
            $report = $next($collectors);

            $fixedReport = $this
                ->jsonFixer
                ->silent(false)
                ->missingValue($missingValue)
                ->fix((string) $report);

            return str(to_pretty_json(json_decode($fixedReport, true, 512, JSON_THROW_ON_ERROR)));
        } catch (\Throwable $throwable) {
            return $report;
        }
    }
}
