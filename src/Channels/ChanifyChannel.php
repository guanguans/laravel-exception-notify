<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Channels;

use Guanguans\Notify\Messages\Chanify\TextMessage;

class ChanifyChannel extends Channel
{
    protected function createMessage(string $report)
    {
        return new TextMessage([
            'title' => config('exception-notify.title'),
            'text' => $report,
        ]);
    }
}
