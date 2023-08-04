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

use Guanguans\LaravelExceptionNotify\Collectors\ChoreCollector;
use Illuminate\Support\Collection;

class AddKeywordPipe
{
    public function handle(Collection $collectors, \Closure $next, string $keyword, $key = 'keyword'): string
    {
        $collectorName = $collectors->has($choreName = ChoreCollector::name())
            ? $choreName
            : array_key_first($collectors->all());

        $collectors = $collectors->transform(
            static function (
                array $collector,
                string $name
            ) use ($collectorName, $key, $keyword) {
                if ($name === $collectorName) {
                    $collector[$key] = $keyword;
                }

                return $collector;
            }
        );

        return $next($collectors);
    }
}
