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

namespace Guanguans\LaravelExceptionNotify\Mail;

use Illuminate\Mail\Mailable;

class ReportExceptionMail extends Mailable
{
    public function __construct(private string $report) {}

    public function build(): self
    {
        return $this
            ->subject(config('exception-notify.title'))
            ->html($this->report);
    }
}
