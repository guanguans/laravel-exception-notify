<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2026 guanguans<ityaozm@gmail.com>
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

if (!\function_exists('Guanguans\LaravelExceptionNotify\Support\make')) {
    /**
     * @see https://github.com/laravel/framework/blob/12.x/src/Illuminate/Foundation/helpers.php
     * @see https://github.com/yiisoft/yii2/blob/master/framework/BaseYii.php
     *
     * @param array<string, mixed>|string $name
     * @param array<string, mixed> $parameters
     *
     * @throws \ReflectionException
     */
    function make(array|string $name, array $parameters = []): mixed
    {
        if (\is_string($name)) {
            return resolve($name, $parameters);
        }

        foreach (
            $keys = [
                '__abstract', '__class', '__name',
                '_abstract', '_class', '_name',
                'abstract', 'class', 'name',
            ] as $key
        ) {
            if (isset($name[$key])) {
                return Utils::applyConfigurationToObject(
                    make($name[$key], $parameters + ($configuration = Arr::except($name, $key))),
                    $configuration
                );
            }
        }

        throw new InvalidArgumentException(
            \sprintf('The argument of name must be an array containing a `%s` element.', implode('` or `', $keys))
        );
    }
}

if (!\function_exists('Guanguans\LaravelExceptionNotify\Support\rescue')) {
    /**
     * @see rescue()
     *
     * @param null|\Closure $rescue
     * @param bool|\Closure $log
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
