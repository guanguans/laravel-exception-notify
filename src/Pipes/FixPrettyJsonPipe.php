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

class FixPrettyJsonPipe
{
    protected JsonFixer $jsonFixer;

    public function __construct(JsonFixer $jsonFixer)
    {
        $this->jsonFixer = $jsonFixer;
    }

    public function handle(Collection $collectors, \Closure $next, string $missingValue = '"..."'): string
    {
        try {
            $report = $next($collectors);
            $fixedJson = $this->jsonFixer->silent(false)->missingValue($missingValue)->fix($report);

            return json_encode(
                json_decode($fixedJson, true),
                JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
            );
        } catch (\Throwable $throwable) {
            return $report;
        }
    }
}
