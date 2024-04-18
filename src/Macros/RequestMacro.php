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
