<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

if (! function_exists('env_explode')) {
    /**
     * @param mixed $default
     *
     * @return mixed
     *
     * @noinspection LaravelFunctionsInspection
     */
    function env_explode(string $key, $default = null, string $delimiter = ',', int $limit = PHP_INT_MAX)
    {
        $env = env($key, $default);
        if (is_string($env)) {
            return explode($delimiter, $env, $limit);
        }

        return $env;
    }
}

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

if (! function_exists('array_is_list')) {
    /**
     * @codeCoverageIgnore
     *
     * @see \Symfony\Polyfill\Php81\Php81::array_is_list
     */
    function array_is_list(array $array): bool
    {
        if ([] === $array || $array === array_values($array)) {
            return true;
        }

        $nextKey = -1;

        $keys = array_keys($array);
        foreach ($keys as $key) {
            if ($key !== ++$nextKey) {
                return false;
            }
        }

        return true;
    }
}

if (! function_exists('json_pretty_encode')) {
    /**
     * @param mixed $value
     *
     * @throws JsonException
     */
    function json_pretty_encode($value, int $options = 0, int $depth = 512): string
    {
        return json_encode(
            $value,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR | $options,
            $depth
        );
    }
}

if (! function_exists('hydrate_pipe')) {
    /**
     * @param class-string $pipe
     */
    function hydrate_pipe(string $pipe, ...$parameters): string
    {
        return [] === $parameters ? $pipe : sprintf('%s:%s', $pipe, implode(',', $parameters));
    }
}

if (! function_exists('human_bytes')) {
    /**
     * Convert bytes to human readable format.
     *
     * @param int $bytes the amount of bytes to convert to human readable format
     * @param int $decimals the number of decimals to use in the resulting string
     *
     * @see https://stackoverflow.com/a/23888858/1580028
     */
    function human_bytes(int $bytes, int $decimals = 2): string
    {
        $size = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $factor = (int) floor((strlen((string) $bytes) - 1) / 3);

        if (0 === $factor) {
            $decimals = 0;
        }

        return sprintf("%.{$decimals}f%s", $bytes / (1024 ** $factor), $size[$factor]);
    }
}

if (! function_exists('human_milliseconds')) {
    function human_milliseconds(float $milliseconds, int $precision = 2): string
    {
        if ($milliseconds < 1) {
            return sprintf('%sμs', round($milliseconds * 1000, $precision));
        }

        if ($milliseconds < 1000) {
            return sprintf('%sms', round($milliseconds, $precision));
        }

        return sprintf('%ss', round($milliseconds / 1000, $precision));
    }
}
