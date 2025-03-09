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

class DumpChannel extends AbstractChannel
{
    /**
     * @noinspection ForgottenDebugOutputInspection
     * @noinspection DebugFunctionUsageInspection
     */
    public function reportContent(string $content): mixed
    {
        return $this->configRepository->get('exit', false) ? dd($content) : dump($content);
    }

    protected function rules(): array
    {
        return [
            'exit' => 'bool',
        ] + parent::rules();
    }
}
