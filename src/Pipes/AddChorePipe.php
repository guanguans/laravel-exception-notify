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
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Stringable;

class AddChorePipe
{
    /**
     * @param mixed $value
     * @param array-key $key
     */
    public function handle(Collection $collectors, \Closure $next, $value, $key): Stringable
    {
        $choreName = ChoreCollector::name();

        $collectors = $collectors->transform(
            static fn (array $collector, string $name): array => $name === $choreName
                ? Arr::add($collector, $key, $value)
                : $collector
        );

        return $next($collectors);
    }
}
