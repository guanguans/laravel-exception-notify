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

use Guanguans\LaravelExceptionNotify\Contracts\ChannelContract;
use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Log;

class LogChannel implements ChannelContract
{
    private Repository $config;

    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    public function report(string $report): void
    {
        Log::channel($this->config->get('channel', 'daily'))->log(
            $this->config->get('level', 'error'),
            $report,
            $this->config->get('context', []),
        );
    }
}
