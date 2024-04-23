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

use Guanguans\LaravelExceptionNotify\Mail\ExceptionReportMail;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MailChannel extends Channel
{
    public function report(string $report): void
    {
        tap(Mail::driver($this->config->get('mailer')), function (Mailer $mailer): void {
            collect($this->config->all())
                ->except(['mailer'])
                ->each(static function ($value, string $key) use ($mailer): void {
                    $mailer->{Str::camel($key)}($value);
                });
        })->send($this->createMail($report));
    }

    private function createMail(string $report): Mailable
    {
        return new ExceptionReportMail($report);
    }
}
