<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Channels;

use Guanguans\Notify\Messages\WeWork\TextMessage;

class WeWorkChannel extends Channel
{
    protected function createMessage(string $report)
    {
        return new TextMessage(['content' => $report]);
    }
}
