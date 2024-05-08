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

namespace Guanguans\LaravelExceptionNotify\Tests\Mail;

use Guanguans\LaravelExceptionNotify\Mail\ReportExceptionMail;

it('can build self', function (): void {
    expect(new ReportExceptionMail($this->faker()->text()))
        ->build()->toBeInstanceOf(ReportExceptionMail::class);
})->group(__DIR__, __FILE__);
