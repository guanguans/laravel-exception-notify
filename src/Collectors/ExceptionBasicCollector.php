<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
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
            'class' => \get_class($this->exception),
            'file' => $this->exception->getFile(),
            'line' => $this->exception->getLine(),
            'status_code' => $this->flattenException->getStatusCode(),
            'status_text' => $this->flattenException->getStatusText(),
            'headers' => $this->flattenException->getHeaders(),
        ];
    }
}
