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
use Illuminate\Support\Stringable;

class AddValuePipe
{
    /**
     * @param mixed $value
     * @param null|array-key $key
     */
    public function handle(Collection $collectors, \Closure $next, $value, $key = null, ?string $collectorName = null): Stringable
    {
        $collectorName ??= ChoreCollector::name();
        $collectorName = (string) ($collectors->has($collectorName) ? $collectorName : array_key_first($collectors->all()));

        $collectors = $collectors->transform(
            static function (
                array $collector,
                string $name
            ) use ($collectorName, $key, $value) {
                if ($name === $collectorName) {
                    null === $key ? $collector[] = $value : $collector[$key] = $value;
                }

                return $collector;
            }
        );

        return $next($collectors);
    }
}
