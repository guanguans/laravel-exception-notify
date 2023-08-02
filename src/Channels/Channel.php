<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Channels;

use Guanguans\LaravelExceptionNotify\Contracts\ChannelContract;
use Illuminate\Support\Str;

abstract class Channel implements ChannelContract
{
    public function name(): string
    {
        return Str::lcfirst(Str::beforeLast(class_basename($this), 'Channel'));
    }
}
