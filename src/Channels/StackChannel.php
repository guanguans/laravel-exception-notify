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

use Guanguans\LaravelExceptionNotify\Facades\ExceptionNotify;

class StackChannel extends Channel
{
    public function report(string $report): array
    {
        return collect($this->configRepository->get('channels'))
            ->map(static fn (string $channel): array => ExceptionNotify::driver($channel)->report($report))
            ->all();
    }

    protected function rules(): array
    {
        return [
            'channels' => 'array',
        ] + parent::rules();
    }
}
