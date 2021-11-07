<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\LaravelExceptionNotify\Facades\Notifier;

if (! function_exists('array_reduces')) {
    /**
     * @param null $carry
     *
     * @return mixed|null
     */
    function array_reduces(array $array, callable $callback, $carry = null)
    {
        foreach ($array as $key => $value) {
            $carry = call_user_func($callback, $carry, $value, $key);
        }

        return $carry;
    }
}

if (! function_exists('notifier_report')) {
    /**
     * Notifier report an exception.
     *
     * @param \Throwable|string $exception
     *
     * @return void
     */
    function notifier_report($exception)
    {
        $exception instanceof Throwable or $exception = new Exception($exception);

        Notifier::report($exception);
    }
}

if (! function_exists('notifier_report')) {
    /**
     * Determine if the given string is in Class@method syntax.
     *
     * @param mixed $callback
     *
     * @return bool
     */
    function is_callable_with_at_sign($callback)
    {
        return is_string($callback) && false !== strpos($callback, '@');
    }
}
