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

namespace Guanguans\LaravelExceptionNotify\Channels;

use Illuminate\Support\Facades\Log;

/**
 * @see \Illuminate\Log\LogManager
 */
class LogChannel extends AbstractChannel
{
    public function reportContent(string $content): mixed
    {
        Log::channel($this->configRepository->get('channel'))->log(
            $this->configRepository->get('level', 'error'),
            $content,
            $this->configRepository->get('context', []),
        );

        return null;
    }

    protected function rules(): array
    {
        return [
            'channel' => 'nullable|string',
            'level' => 'string',
            'context' => 'array',
        ] + parent::rules();
    }
}
