<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace {
    class ExceptionNotify extends \Guanguans\LaravelExceptionNotify\Facades\ExceptionNotify
    {
    }
}

namespace Illuminate\Support {
    /**
     * @method mixed reduceWithKeys(callable $callback, $carry = null)
     *
     * @see \Guanguans\LaravelExceptionNotify\Macros\CollectionMacro
     * @see \Illuminate\Support\Collection
     */
    class Collection
    {
    }

    /**
     * @method string beforeLast($subject, $search)
     * @method string lcfirst($string)
     * @method string ucwords($string)
     *
     * @see \Guanguans\LaravelExceptionNotify\Macros\StrMacro
     * @see \Illuminate\Support\Str
     */
    class Str
    {
    }
}

namespace Illuminate\Http {
    /**
     * @method array headers($key = null, $default = null)
     *
     * @see \Guanguans\LaravelExceptionNotify\Macros\RequestMacro
     * @see \Illuminate\Http\Request
     */
    class Collection
    {
    }
}
