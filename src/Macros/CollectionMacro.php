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
 * @mixin \Illuminate\Support\Collection
 */
class CollectionMacro
{
    public function reduceWithKeys(): callable
    {
        return fn (callable $callback, $carry = null) => array_reduce_with_keys($this->items, $callback, $carry);
    }
}
