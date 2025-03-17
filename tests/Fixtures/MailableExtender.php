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

namespace Guanguans\LaravelExceptionNotifyTests\Fixtures;

use Illuminate\Mail\Mailable;

class MailableExtender
{
    public function __invoke(Mailable $mailable): Mailable
    {
        return $mailable;
    }
}
