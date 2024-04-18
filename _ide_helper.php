<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

namespace {
    class ExceptionNotify extends Guanguans\LaravelExceptionNotify\Facades\ExceptionNotify {}
}

namespace Illuminate\Support {
    /**
     * @method string lcfirst($string)
     * @method string ucwords($string)
     *
     * @see \Guanguans\LaravelExceptionNotify\Macros\StrMacro
     * @see \Illuminate\Support\Str
     */
    class Str {}

    /**
     * @method \Illuminate\Support\Stringable lcfirst()
     * @method \Illuminate\Support\Stringable ucwords()
     *
     * @see \Guanguans\LaravelExceptionNotify\Macros\StringableMacro
     * @see \Illuminate\Support\Stringable
     */
    class Stringable {}
}

namespace Illuminate\Http {
    /**
     * @method array headers($key = null, $default = null)
     *
     * @see \Guanguans\LaravelExceptionNotify\Macros\RequestMacro
     * @see \Illuminate\Http\Request
     */
    class Collection {}
}
