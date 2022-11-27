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

/**
 * @mixin \Illuminate\Support\Collection
 */
class CollectionMacro
{
    public function reduces(): callable
    {
        return function (callable $callback, $carry = null) {
            return array_reduces($this->items, $callback, $carry);
        };
    }
}
