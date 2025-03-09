<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

namespace Guanguans\LaravelExceptionNotify\Support\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait ApplyConfigurationToObjectable
{
    protected function applyConfigurationToObject(
        object $object,
        array $configuration,
        ?array $except = null
    ): object {
        return collect($configuration)
            ->except($except)
            // ->filter(static fn (mixed $value): bool => \is_array($value) && !array_is_list($value))
            ->each(static function (mixed $value, string $key) use ($object): void {
                foreach (
                    [
                        static fn (string $key): string => $key,
                        static fn (string $key): string => Str::camel($key),
                        static fn (string $key): string => 'set'.Str::studly($key),
                        static fn (string $key): string => 'on'.Str::studly($key),
                    ] as $case
                ) {
                    if (method_exists($object, $method = $case($key))) {
                        $numberOfParameters = (new \ReflectionMethod($object, $method))->getNumberOfParameters();

                        if (1 === $numberOfParameters) {
                            $object->{$method}($value);

                            return;
                        }

                        app()->call([$object, $method], $value);

                        return;
                    }
                }
            })
            ->pipe(static fn (Collection $configuration): object => $object);
    }
}
