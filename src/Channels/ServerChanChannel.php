<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Channels;

use Guanguans\Notify\Messages\ServerChanMessage;

class ServerChanChannel extends Channel
{
    protected function createMessage(string $content)
    {
        return new ServerChanMessage(config('exception-notify.title'), $content);
    }
}
