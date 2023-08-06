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

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Stringable;

class OnlyKeysPipe
{
    /**
     * @noinspection CallableParameterUseCaseInTypeContextInspection
     */
    public function handle(Collection $collectors, \Closure $next, string $keys, string $collectorName): Stringable
    {
        $keys = explode('|', $keys);

        $collectors = $collectors->transform(
            static function (
                array $collector,
                string $name
            ) use ($collectorName, $keys) {
                if ($name === $collectorName) {
                    return Arr::only($collector, $keys);
                }

                return $collector;
            }
        );

        return $next($collectors);
    }
}
