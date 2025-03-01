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

use Guanguans\LaravelExceptionNotify\Exceptions\InvalidArgumentException;
use Illuminate\Support\Arr;

if (!\function_exists('make')) {
    /**
     * @psalm-param string|array<string, mixed> $abstract
     *
     * @param mixed $abstract
     *
     * @throws \InvalidArgumentException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return mixed
     */
    function make($abstract, array $parameters = [])
    {
        if (!\is_string($abstract) && !\is_array($abstract)) {
            throw new InvalidArgumentException(
                \sprintf('Invalid argument type(string/array): %s.', \gettype($abstract))
            );
        }

        if (\is_string($abstract)) {
            return resolve($abstract, $parameters);
        }

        $classes = ['__class', '_class', 'class'];

        foreach ($classes as $class) {
            if (!isset($abstract[$class])) {
                continue;
            }

            $parameters = Arr::except($abstract, $class) + $parameters;
            $abstract = $abstract[$class];

            return make($abstract, $parameters);
        }

        throw new InvalidArgumentException(\sprintf(
            'The argument of abstract must be an array containing a `%s` element.',
            implode('` or `', $classes)
        ));
    }
}

if (!\function_exists('env_explode')) {
    /**
     * @noinspection LaravelFunctionsInspection
     *
     * @param mixed $default
     *
     * @return mixed
     */
    function env_explode(string $key, $default = null, string $delimiter = ',', int $limit = \PHP_INT_MAX)
    {
        $env = env($key, $default);

        if (\is_string($env)) {
            return $env ? explode($delimiter, $env, $limit) : [];
        }

        return $env;
    }
}

if (!\function_exists('json_pretty_encode')) {
    /**
     * @param mixed $value
     *
     * @throws JsonException
     */
    function json_pretty_encode($value, int $options = 0, int $depth = 512): string
    {
        return json_encode(
            $value,
            \JSON_PRETTY_PRINT | \JSON_UNESCAPED_UNICODE | \JSON_UNESCAPED_SLASHES | \JSON_THROW_ON_ERROR | $options,
            $depth
        );
    }
}

if (!\function_exists('hydrate_pipe')) {
    /**
     * @param class-string $pipe
     */
    function hydrate_pipe(string $pipe, ...$parameters): string
    {
        return [] === $parameters ? $pipe : \sprintf('%s:%s', $pipe, implode(',', $parameters));
    }
}

if (!\function_exists('human_bytes')) {
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
        $factor = (int) floor((\strlen((string) $bytes) - 1) / 3);

        if (0 === $factor) {
            $decimals = 0;
        }

        return \sprintf("%.{$decimals}f%s", $bytes / (1024 ** $factor), $size[$factor]);
    }
}

if (!\function_exists('human_milliseconds')) {
    function human_milliseconds(float $milliseconds, int $precision = 2): string
    {
        if (1 > $milliseconds) {
            return \sprintf('%sμs', round($milliseconds * 1000, $precision));
        }

        if (1000 > $milliseconds) {
            return \sprintf('%sms', round($milliseconds, $precision));
        }

        return \sprintf('%ss', round($milliseconds / 1000, $precision));
    }
}
