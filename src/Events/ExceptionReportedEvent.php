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

namespace Guanguans\LaravelExceptionNotify\Events;

use Guanguans\LaravelExceptionNotify\Contracts\Channel;

class ExceptionReportedEvent
{
    public Channel $channel;

    /** @var mixed */
    public $result;

    /**
     * @noinspection MissingParameterTypeDeclarationInspection
     *
     * @param mixed $result
     */
    public function __construct(Channel $channel, $result)
    {
        $this->channel = $channel;
        $this->result = $result;
    }
}
