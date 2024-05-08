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

use Guanguans\LaravelExceptionNotify\Exceptions\InvalidArgumentException;
use Guanguans\LaravelExceptionNotify\Mail\ReportExceptionMail;
use Illuminate\Config\Repository;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\PendingMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MailChannel extends Channel
{
    public function __construct(Repository $config)
    {
        $validator = validator($config->all(), [
            'mailer' => 'nullable|string',
            'to' => 'required|array',
            'extender' => static function (string $attribute, $value, \Closure $fail): void {
                if (\is_string($value) || \is_callable($value)) {
                    return;
                }

                $fail("The $attribute must be a callable or string.");
            },
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        parent::__construct($config);
    }

    public function report(string $report): void
    {
        /** @var Mailer|PendingMail $mailerOrPendingMail */
        $mailerOrPendingMail = collect($this->config->all())
            ->except(['driver', 'mailer', 'extender', 'pipes'])
            ->reduce(
                static function (object $mailerOrPendingMail, array $parameters, string $method): object {
                    $object = app()->call([$mailerOrPendingMail, Str::camel($method)], $parameters);

                    return \is_object($object) ? $object : $mailerOrPendingMail;
                },
                Mail::mailer($this->config->get('mailer'))
            );

        if ($this->config->has('extender')) {
            $mailerOrPendingMail = app()->call($this->config->get('extender'), ['mailerOrPendingMail' => $mailerOrPendingMail]);
        }

        $mailerOrPendingMail->send(new ReportExceptionMail($report));
    }
}
