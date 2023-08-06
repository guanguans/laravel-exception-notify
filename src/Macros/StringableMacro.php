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

    public function squish(): callable
    {
        return fn (): self => new static(Str::squish($this->value));
    }

    public function toString(): callable
    {
        return fn (): string => $this->value;
    }
}
