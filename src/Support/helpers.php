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

namespace Guanguans\LaravelExceptionNotify\Support;

use Guanguans\LaravelExceptionNotify\Exceptions\InvalidArgumentException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

if (!\function_exists('Guanguans\LaravelExceptionNotify\Support\make')) {
    /**
     * @see https://github.com/yiisoft/yii2/blob/master/framework/BaseYii.php
     *
     * @param array<string, mixed>|string $abstract
     * @param array<string, mixed> $parameters
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    function make(array|string $abstract, array $parameters = []): mixed
    {
        if (\is_string($abstract)) {
            return resolve($abstract, $parameters);
        }

        foreach (
            $keys ??= [
                '__abstract',
                '__class',
                '__name',
                '_abstract',
                '_class',
                '_name',
                'abstract',
                'class',
                'name',
            ] as $key
        ) {
            if (isset($abstract[$key])) {
                return make($abstract[$key], $parameters + Arr::except($abstract, $key));
            }
        }

        throw new InvalidArgumentException(\sprintf(
            'The argument of abstract must be an array containing a `%s` element.',
            implode('` or `', $keys)
        ));
    }
}

if (!\function_exists('Guanguans\LaravelExceptionNotify\Support\rescue')) {
    /**
     * @param null|\Closure $rescue
     * @param bool|\Closure $log
     *
     * @see rescue()
     */
    function rescue(callable $callback, mixed $rescue = null, mixed $log = true): mixed
    {
        try {
            return $callback();
        } catch (\Throwable $throwable) {
            if (value($log, $throwable)) {
                Log::error($throwable->getMessage(), ['exception' => $throwable]);
            }

            return value($rescue, $throwable);
        }
    }
}

if (!\function_exists('Guanguans\LaravelExceptionNotify\Support\env_explode')) {
    /**
     * @noinspection LaravelFunctionsInspection
     */
    function env_explode(string $key, mixed $default = null, string $delimiter = ',', int $limit = \PHP_INT_MAX): mixed
    {
        $env = env($key, $default);

        if (\is_string($env)) {
            return $env ? explode($delimiter, $env, $limit) : [];
        }

        return $env;
    }
}

if (!\function_exists('Guanguans\LaravelExceptionNotify\Support\json_pretty_encode')) {
    /**
     * @param int<1, 4194304> $depth
     *
     * @throws \JsonException
     */
    function json_pretty_encode(mixed $value, int $options = 0, int $depth = 512): string
    {
        return json_encode(
            $value,
            \JSON_PRETTY_PRINT | \JSON_UNESCAPED_UNICODE | \JSON_UNESCAPED_SLASHES | \JSON_THROW_ON_ERROR | $options,
            $depth
        );
    }
}

if (!\function_exists('Guanguans\LaravelExceptionNotify\Support\human_bytes')) {
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

if (!\function_exists('Guanguans\LaravelExceptionNotify\Support\human_milliseconds')) {
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
