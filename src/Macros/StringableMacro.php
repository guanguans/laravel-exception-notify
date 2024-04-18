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

use Illuminate\Support\Str;

/**
 * @mixin \Illuminate\Support\Stringable
 */
class StringableMacro
{
    public function lcfirst(): callable
    {
        return fn (): self => new static(Str::lcfirst($this->value));
    }

    public function ucwords(): callable
    {
        return fn (): self => new static(Str::ucwords($this->value));
    }
}
