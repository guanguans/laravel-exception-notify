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

class RequestHeaderCollector extends AbstractCollector
{
    private array $except;

    public function __construct(
        private Request $request,
        ?array $except = null
    ) {
        $this->except = $except ?? [
            'Authorization',
            'Cookie',
        ];
    }

    public function collect(): array
    {
        return collect($this->request->header())
            ->reject(fn (array $header, string $key): bool => str($key)->is($this->except))
            ->map(static fn (array $header): string => $header[0])
            ->all();
    }
}
