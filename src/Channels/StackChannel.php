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

class StackChannel extends AbstractChannel
{
    public function report(\Throwable $throwable): void
    {
        collect($this->configRepository->get('channels'))->each(
            static fn (string $channel) => ExceptionNotify::driver($channel)->report($throwable)
        );
    }

    public function reportContent(string $content): array
    {
        return collect($this->configRepository->get('channels'))
            ->mapWithKeys(
                static fn (string $channel): array => [$channel => ExceptionNotify::driver($channel)->reportContent($content)]
            )
            ->all();
    }

    protected function rules(): array
    {
        return [
            'channels' => 'array',
        ] + parent::rules();
    }
}
