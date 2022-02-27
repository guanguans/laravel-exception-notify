<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Collectors;

use ArrayAccess;
use Guanguans\LaravelExceptionNotify\Contracts\Collector as CollectorContract;
use Guanguans\LaravelExceptionNotify\Support\Traits\OptionsProperty;
use Illuminate\Support\Str;

abstract class Collector implements CollectorContract, ArrayAccess
{
    use OptionsProperty;

    public function getName(): string
    {
        return Str::ucfirst(Str::beforeLast(class_basename($this), 'Collector'));
    }

    public function __toString()
    {
        return varexport(
            array_filter($this->collect(), function ($value) {
                return ! blank($value);
            }),
            true
        );
    }
}
