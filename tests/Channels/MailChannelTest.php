<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection StaticClosureCanBeUsedInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2021-2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

use Guanguans\LaravelExceptionNotify\ExceptionNotifyManager;

it('will throw `InvalidArgumentException`', function (): void {
    config()->set('exception-notify.channels.mail.extender', null);

    $this->app->make(ExceptionNotifyManager::class)->driver('mail');
})->group(__DIR__, __FILE__)->throws(\Guanguans\LaravelExceptionNotify\Exceptions\InvalidArgumentException::class);

it('will throw `TransportException`', function (): void {
    config()->set(
        'exception-notify.channels.mail.extender',
        static fn (object $mailerOrPendingMail): object => $mailerOrPendingMail
    );

    $this->app->make(ExceptionNotifyManager::class)->driver('mail')->report('report');
})->group(__DIR__, __FILE__)->throws(Swift_TransportException::class);
