<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Channels;

use Guanguans\Notify\Messages\EmailMessage;

class MailChannel extends Channel
{
    protected function createMessage(string $report)
    {
        return EmailMessage::create()
            ->from(config('exception-notify.channels.mail.from'))
            ->to(config('exception-notify.channels.mail.to'))
            ->subject(config('exception-notify.title'))
            ->html($report);
    }
}
