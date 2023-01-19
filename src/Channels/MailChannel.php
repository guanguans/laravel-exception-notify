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

use Guanguans\Notify\Contracts\MessageInterface;
use Guanguans\Notify\Messages\EmailMessage;

class MailChannel extends NotifyChannel
{
    protected function createMessage(string $report): MessageInterface
    {
        $emailMessage = EmailMessage::create()
            ->from(config('exception-notify.channels.mail.from'))
            ->to(config('exception-notify.channels.mail.to'))
            ->subject(config('exception-notify.title'))
            ->html($report);

        $cc = config('exception-notify.channels.mail.cc') and $emailMessage->cc($cc);
        $bcc = config('exception-notify.channels.mail.bcc') and $emailMessage->bcc($bcc);
        $replyTo = config('exception-notify.channels.mail.reply_to') and $emailMessage->replyTo($replyTo);

        return $emailMessage;
    }
}
