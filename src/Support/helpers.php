<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\LaravelExceptionNotify\Facades\ExceptionNotify;

if (! function_exists('array_filter_filled')) {
    function array_filter_filled(array $array): array
    {
        return array_filter($array, static function ($item) {
            return ! blank($item);
        });
    }
}

if (! function_exists('call')) {
    /**
     * Call the given Closure / class@method and inject its dependencies.
     *
     * @param callable|string      $callback
     * @param array<string, mixed> $parameters
     */
    function call($callback, array $parameters = [], ?string $defaultMethod = 'handle')
    {
        is_callable($callback) and $defaultMethod = null;

        return app()->call($callback, $parameters, $defaultMethod);
    }
}

if (! function_exists('var_output')) {
    /**
     * @return string|void|null
     *
     * @noinspection DebugFunctionUsageInspection
     */
    function var_output($expression, bool $return = false)
    {
        $patterns = [
            "/array \(\n\)/" => '[]',
            "/array \(\n\s+\)/" => '[]',
            "/array \(/" => '[',
            "/^([ ]*)\)(,?)$/m" => '$1]$2',
            "/=>[ ]?\n[ ]+\[/" => '=> [',
            "/([ ]*)(\'[^\']+\') => ([\[\'])/" => '$1$2 => $3',
        ];

        $export = var_export($expression, true);
        $export = preg_replace(array_keys($patterns), array_values($patterns), $export);
        if ($return) {
            return $export;
        }

        echo $export;
    }
}

if (! function_exists('array_reduce_with_keys')) {
    /**
     * @return mixed|null
     */
    function array_reduce_with_keys(array $array, callable $callback, $carry = null)
    {
        foreach ($array as $key => $value) {
            $carry = call_user_func($callback, $carry, $value, $key);
        }

        return $carry;
    }
}

if (! function_exists('exception_notify_report_if')) {
    function exception_notify_report_if($condition, $exception, ...$channels): void
    {
        value($condition) and exception_notify_report($exception, ...$channels);
    }
}

if (! function_exists('exception_notify_report')) {
    function exception_notify_report($exception, ...$channels): void
    {
        $exception instanceof Throwable or $exception = new Exception($exception);

        ExceptionNotify::onChannel(...$channels)->report($exception);
    }
}

if (! function_exists('is_callable_with_at_sign')) {
    /**
     * Determine if the given string is in Class@method syntax.
     */
    function is_callable_with_at_sign($callback): bool
    {
        return is_string($callback) && str_contains($callback, '@');
    }
}
