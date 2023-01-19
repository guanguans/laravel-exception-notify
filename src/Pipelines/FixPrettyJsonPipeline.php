<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Pipelines;

use Guanguans\LaravelExceptionNotify\Support\JsonFixer;

class FixPrettyJsonPipeline
{
    /**
     * @var \Guanguans\LaravelExceptionNotify\Support\JsonFixer
     */
    protected $jsonFixer;

    public function __construct(JsonFixer $jsonFixer)
    {
        $this->jsonFixer = $jsonFixer;
    }

    public function handle(string $report, \Closure $next, string $missingValue = '"..."'): string
    {
        try {
            $fixedJson = $this->jsonFixer->silent(false)->missingValue($missingValue)->fix($report);

            return $next(json_encode(
                json_decode($fixedJson, true),
                JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
            ));
        } catch (\Throwable $throwable) {
            return $next($report);
        }
    }
}
