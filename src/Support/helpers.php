<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Illuminate\Container\Container;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Laravel\Lumen\Application as LumenApplication;

if (! function_exists('array_filter_filled')) {
    function array_filter_filled(array $array): array
    {
        return array_filter($array, static fn ($item): bool => filled($item));
    }
}

if (! function_exists('array_reduce_with_keys')) {
    /**
     * @param null|mixed $carry
     *
     * @return null|mixed
     *
     * @codeCoverageIgnore
     */
    function array_reduce_with_keys(array $array, callable $callback, $carry = null)
    {
        foreach ($array as $key => $value) {
            $carry = $callback($carry, $value, $key);
        }

        return $carry;
    }
}

if (! function_exists('str')) {
    /**
     * @param mixed $string
     *
     * @return Stringable|\Stringable
     */
    function str($string = null)
    {
        if (0 === func_num_args()) {
            return new class() implements \Stringable {
                public function __call($method, $parameters)
                {
                    return Str::$method(...$parameters);
                }

                public function __toString()
                {
                    return '';
                }
            };
        }

        return Str::of($string);
    }
}

if (! function_exists('to_pretty_json')) {
    /**
     * @param mixed $value
     *
     * @throws JsonException
     */
    function to_pretty_json($value, int $options = 0, int $depth = 512): string
    {
        return json_encode(
            $value,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR | $options,
            $depth
        );
    }
}

if (! function_exists('is_lumen')) {
    function is_lumen(?Container $app = null): bool
    {
        return ($app ?? app()) instanceof LumenApplication;
    }
}

if (! function_exists('hydrate_pipe')) {
    /**
     * @param class-string $pipe
     */
    function hydrate_pipe(string $pipe, ...$parameters): string
    {
        return sprintf('%s:%s', $pipe, implode(',', $parameters));
    }
}
