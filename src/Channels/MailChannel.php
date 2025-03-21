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

use Guanguans\LaravelExceptionNotify\Support\Utils;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\SentMessage;
use Illuminate\Support\Facades\Mail;
use function Guanguans\LaravelExceptionNotify\Support\make;

/**
 * @see \Illuminate\Mail\MailManager
 * @see \Illuminate\Mail\Mailer
 * @see \Illuminate\Mail\PendingMail
 */
class MailChannel extends AbstractChannel
{
    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function reportContent(string $content): ?SentMessage
    {
        return Mail::mailer($this->configRepository->get('mailer'))->send($this->makeMail($content));
    }

    protected function rules(): array
    {
        return [
            'mailer' => 'nullable|string',
            'class' => 'required|string',
            'to' => 'required|array',
        ] + parent::rules();
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function makeMail(string $content): Mailable
    {
        return Utils::applyConfigurationToObject(
            make($configuration = Utils::applyContentToConfiguration($this->configRepository->all(), $content)),
            $configuration
        );
    }
}
