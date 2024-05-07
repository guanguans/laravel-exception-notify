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
        $mailer = Mail::driver($this->config->get('mailer'));

        $reflectionObjectOfMailer = new \ReflectionObject($mailer);

        $mailer = collect($this->config->all())
            ->except(['mailer', 'extender', 'pipes'])
            ->reduce(
                static function (Mailer $mailer, $parameters, string $method) use ($reflectionObjectOfMailer): Mailer {
                    $method = Str::camel($method);

                    return $reflectionObjectOfMailer->getMethod($method)->getNumberOfParameters() > 1
                        ? $mailer->{$method}(...$parameters)
                        : $mailer->{$method}($parameters);
                },
                $mailer
            );

        if ($this->config->has('extender')) {
            $mailer = app()->call($this->config->get('extender'), ['mailer' => $mailer]);
        }

        $mailer->send($this->createMail($report));
    }

    private function createMail(string $report): Mailable
    {
        return new ExceptionReportMail($report);
    }
}
