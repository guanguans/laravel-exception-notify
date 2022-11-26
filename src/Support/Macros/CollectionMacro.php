<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Support\Macros;

class CollectionMacro
{
    public function reduces(): callable
    {
        return function (callable $callback, $carry = null) {
            /* @var \Illuminate\Support\Collection $this */
            return array_reduces($this->items, $callback, $carry);
        };
    }
}
