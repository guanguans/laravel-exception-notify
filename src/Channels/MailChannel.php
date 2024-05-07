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

use Guanguans\LaravelExceptionNotify\Mail\ReportExceptionMail;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\PendingMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MailChannel extends Channel
{
    public function report(string $report): void
    {
        /** @var Mailer|PendingMail $mailerOrPendingMail */
        $mailerOrPendingMail = collect($this->config->all())
            ->except(['driver', 'mailer', 'extender', 'pipes'])
            ->reduce(
                static function (object $mailerOrPendingMail, $parameters, string $method): object {
                    $method = Str::camel($method);

                    $object = 1 < (new \ReflectionObject($mailerOrPendingMail))->getMethod($method)->getNumberOfParameters()
                        ? $mailerOrPendingMail->{$method}(...$parameters)
                        : $mailerOrPendingMail->{$method}($parameters);

                    return \is_object($object) ? $object : $mailerOrPendingMail;
                },
                Mail::driver($this->config->get('mailer'))
            );

        if ($this->config->has('extender')) {
            $mailerOrPendingMail = app()->call($this->config->get('extender'), ['mailerOrPendingMail' => $mailerOrPendingMail]);
        }

        $mailerOrPendingMail->send(new ReportExceptionMail($report));
    }
}
