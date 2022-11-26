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

use Guanguans\LaravelExceptionNotify\Contracts\Channel as ChannelContract;
use Guanguans\LaravelExceptionNotify\Support\Traits\CreateStatic;
use Illuminate\Support\Str;

abstract class Channel implements ChannelContract
{
    use CreateStatic;

    public function getName(): string
    {
        return Str::lcfirst(Str::beforeLast(class_basename($this), 'Channel'));
    }
}
