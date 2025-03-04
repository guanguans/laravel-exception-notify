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

namespace Guanguans\LaravelExceptionNotify\Channels;

use Illuminate\Support\Facades\Log;

class LogChannel extends Channel
{
    public function report(string $report): mixed
    {
        Log::channel($this->configRepository->get('channel'))->log(
            $this->configRepository->get('level', 'error'),
            $report,
            $this->configRepository->get('context', []),
        );

        return null;
    }
}
