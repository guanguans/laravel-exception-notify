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
     * @method string squish($string)
     *
     * @see \Guanguans\LaravelExceptionNotify\Macros\StrMacro
     * @see \Illuminate\Support\Str
     */
    class Str
    {
    }

    /**
     * @method \Illuminate\Support\Stringable beforeLast($search)
     * @method \Illuminate\Support\Stringable lcfirst()
     * @method \Illuminate\Support\Stringable ucwords()
     * @method \Illuminate\Support\Stringable squish()
     * @method string toString()
     *
     * @see \Guanguans\LaravelExceptionNotify\Macros\StringableMacro
     * @see \Illuminate\Support\Stringable
     */
    class Stringable
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
