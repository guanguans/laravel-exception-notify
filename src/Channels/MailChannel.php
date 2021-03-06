<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Channels;

use Guanguans\Notify\Contracts\MessageInterface;
use Guanguans\Notify\Messages\EmailMessage;

class MailChannel extends NotifyChannel
{
    protected function createMessage(string $report): MessageInterface
    {
        $message = EmailMessage::create()
            ->from(config('exception-notify.channels.mail.from'))
            ->to(config('exception-notify.channels.mail.to'))
            ->subject(config('exception-notify.title'))
            ->html($report);

        $cc = config('exception-notify.channels.mail.cc') and $message->cc($cc);
        $bcc = config('exception-notify.channels.mail.bcc') and $message->bcc($bcc);
        $replyTo = config('exception-notify.channels.mail.reply_to') and $message->replyTo($replyTo);

        return $message;
    }
}
