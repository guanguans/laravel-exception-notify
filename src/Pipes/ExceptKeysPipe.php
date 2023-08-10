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

use Illuminate\Support\Collection;
use Illuminate\Support\Stringable;

class ExceptKeysPipe
{
    /**
     * @noinspection CallableParameterUseCaseInTypeContextInspection
     */
    public function handle(Collection $collectors, \Closure $next, string $keys, ?string $name = null): Stringable
    {
        $keys = (array) explode('|', $keys);
        if ($name) {
            $keys = array_map(static fn (string $key): string => "$name.$key", $keys);
        }

        return $next($collectors->except($keys));
    }
}
