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

use Illuminate\Http\Request;

class RequestPostCollector extends AbstractCollector
{
    private array $masks;

    public function __construct(
        private Request $request,
        ?array $masks = null
    ) {
        $this->masks = $masks ?? [
            'password',
            '*password',
            'password*',
            '*password*',
        ];
    }

    public function collect(): array
    {
        return collect($this->request->post())
            ->map(fn (mixed $value, string $key): mixed => str($key)->is($this->masks) ? '******' : $value)
            ->all();
    }
}
