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

namespace Guanguans\LaravelExceptionNotify\Collectors;

class ExceptionBasicCollector extends AbstractExceptionCollector
{
    /**
     * @see https://github.com/symfony/symfony/blob/7.1/src/Symfony/Component/Messenger/Transport/Serialization/Normalizer/FlattenExceptionNormalizer.php
     */
    public function collect(): array
    {
        return [
            'Message' => $this->exception->getMessage(),
            'Code' => $this->exception->getCode(),
            'Class' => $this->exception::class,
            'File' => $this->exception->getFile(),
            'Line' => $this->exception->getLine(),
        ];
    }
}
