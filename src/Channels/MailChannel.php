<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2025 guanguans<ityaozm@gmail.com>
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
    public function report(string $report): mixed
    {
        /** @var Mailer|PendingMail $mailerOrPendingMail */
        $mailerOrPendingMail = collect($this->configRepository->all())
            ->except(['driver', 'mailer', 'extender', 'pipes'])
            ->reduce(
                static function (object $mailerOrPendingMail, array $parameters, string $method): object {
                    $object = app()->call([$mailerOrPendingMail, Str::camel($method)], $parameters);

                    return \is_object($object) ? $object : $mailerOrPendingMail;
                },
                Mail::mailer($this->configRepository->get('mailer'))
            );

        if ($this->configRepository->has('extender')) {
            $mailerOrPendingMail = app()->call($this->configRepository->get('extender'), ['mailerOrPendingMail' => $mailerOrPendingMail]);
        }

        return $mailerOrPendingMail->send(new ReportExceptionMail($report));
    }

    protected function rules(): array
    {
        return [
            'mailer' => 'nullable|string',
            'to' => 'required|array',
            'extender' => static function (string $attribute, mixed $value, \Closure $fail): void {
                if (\is_string($value) || \is_callable($value)) {
                    return;
                }

                $fail("The $attribute must be a callable or string.");
            },
        ] + parent::rules();
    }
}
