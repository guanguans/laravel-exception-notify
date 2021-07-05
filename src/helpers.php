<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

if (! function_exists('memoization')) {
    /**
     * 记忆录.
     *
     * Reference @see https://github.com/spatie/once
     *
     * @param ...$parameter
     *
     * @return mixed
     */
    function memoization(callable $callback, ...$parameter)
    {
        $parameters = array_merge((array) $callback, $parameter);

        $uniqueKey = array_reduce($parameters, function ($carry, $parameter) {
            return $carry.md5(var_export($parameter, true));
        }, '');

        global $memoize0411bbf538f3d60ccbdfa6c6b867b979;

        if (! isset($memoize0411bbf538f3d60ccbdfa6c6b867b979[$uniqueKey])) {
            $memoize0411bbf538f3d60ccbdfa6c6b867b979[$uniqueKey] = call_user_func_array($callback, $parameters);
        }

        return $memoize0411bbf538f3d60ccbdfa6c6b867b979[$uniqueKey];
    }
}
