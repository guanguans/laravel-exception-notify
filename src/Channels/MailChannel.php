<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
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
