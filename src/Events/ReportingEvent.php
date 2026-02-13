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

namespace Guanguans\LaravelExceptionNotify\Events;

use Guanguans\LaravelExceptionNotify\Contracts\ChannelContract;

class ReportingEvent
{
    public function __construct(
        public readonly ChannelContract $channelContract,
        public readonly string $content
    ) {}
}
