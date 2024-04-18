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

use Guanguans\Notify\Contracts\MessageInterface;
use Guanguans\Notify\Messages\XiZhiMessage;

class XiZhiChannel extends NotifyChannel
{
    protected function createMessage(string $report): MessageInterface
    {
        return new XiZhiMessage(config('exception-notify.title'), $report);
    }
}
