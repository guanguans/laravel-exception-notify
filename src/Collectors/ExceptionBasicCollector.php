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

namespace Guanguans\LaravelExceptionNotify\Collectors;

class ExceptionBasicCollector extends ExceptionCollector
{
    /**
     * @@see https://github.com/symfony/symfony/blob/7.1/src/Symfony/Component/Messenger/Transport/Serialization/Normalizer/FlattenExceptionNormalizer.php
     */
    public function collect(): array
    {
        return [
            'message' => $this->exception->getMessage(),
            'code' => $this->exception->getCode(),
            'class' => $this->exception::class,
            'file' => $this->exception->getFile(),
            'line' => $this->exception->getLine(),
            // 'status_code' => $this->flattenException->getStatusCode(),
            // 'status_text' => $this->flattenException->getStatusText(),
            // 'headers' => $this->flattenException->getHeaders(),
        ];
    }
}
