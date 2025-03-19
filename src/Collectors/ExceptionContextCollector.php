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

use Guanguans\LaravelExceptionNotify\Support\ExceptionContext;

class ExceptionContextCollector extends AbstractExceptionCollector
{
    public function __construct(
        private string $mark = '➤',
        private int $number = 5
    ) {}

    public function collect(): array
    {
        return ExceptionContext::getMarked($this->exception, $this->mark, $this->number);
    }
}
