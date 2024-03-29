<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Macros;

/**
 * @mixin \Illuminate\Http\Request
 */
class RequestMacro
{
    public function headers(): callable
    {
        return function ($key = null, $default = null) {
            if (null !== $key) {
                return $this->header($key, $default);
            }

            return collect($this->header())
                ->map(static fn ($header) => $header[0])
                ->all();
        };
    }
}
