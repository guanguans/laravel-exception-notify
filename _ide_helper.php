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

namespace {
    class ExceptionNotify extends Guanguans\LaravelExceptionNotify\Facades\ExceptionNotify {}
}

namespace Illuminate\Support {
    /**
     * @mixin  \Illuminate\Support\Str
     */
    class Str {}

    /**
     * @mixin \Illuminate\Support\Stringable
     */
    class Stringable {}
}
