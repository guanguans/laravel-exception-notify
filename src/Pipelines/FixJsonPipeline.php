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

use Closure;
use Guanguans\LaravelExceptionNotify\Support\JsonFixer;
use Throwable;

class FixJsonPipeline
{
    /**
     * @var \Guanguans\LaravelExceptionNotify\Support\JsonFixer
     */
    protected $jsonFixer;

    public function __construct(JsonFixer $jsonFixer)
    {
        $this->jsonFixer = $jsonFixer;
    }

    public function handle(string $report, Closure $next, string $missingValue = 'null'): string
    {
        try {
            // 暂未支持
            return $next($this->jsonFixer->silent(false)->missingValue($missingValue)->fix($report));
        } catch (Throwable $e) {
            return $next($report);
        }
    }
}
