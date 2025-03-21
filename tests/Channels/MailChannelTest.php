<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpInternalEntityUsedInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */
/** @noinspection StaticClosureCanBeUsedInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2021-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

use Guanguans\LaravelExceptionNotify\ExceptionNotifyManager;
use Guanguans\LaravelExceptionNotify\Exceptions\RuntimeException;
use Guanguans\LaravelExceptionNotify\Mail\ReportExceptionMail;
use Guanguans\LaravelExceptionNotifyTests\Fixtures\MailableExtender;
use Illuminate\Support\Facades\Mail;

it('can report', function (): void {
    config([
        'exception-notify.channels.mail.render' => 'value',
        'exception-notify.channels.mail.extender' => MailableExtender::class,
    ]);

    expect($this->app->make(ExceptionNotifyManager::class)->driver('mail'))
        ->report(new RuntimeException('testing'))
        ->toBeNull();
    Mail::assertSent(ReportExceptionMail::class);
})->group(__DIR__, __FILE__);
