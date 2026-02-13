<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2026 guanguans<ityaozm@gmail.com>
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
    public function __construct(
        private string $title,
        private string $content
    ) {}

    public function build(): self
    {
        return $this
            ->subject($this->title)
            ->html($this->content);
    }
}
