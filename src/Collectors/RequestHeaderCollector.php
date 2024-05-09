<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

namespace Guanguans\LaravelExceptionNotify\Collectors;

use Illuminate\Http\Request;

class RequestHeaderCollector extends Collector
{
    private const REJECTED_HEADERS = [
        'Authorization',
        'Cookie',
    ];
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @noinspection PhpUndefinedMethodInspection
     */
    public function collect(): array
    {
        return collect($this->request->header())
            ->reject(static fn (array $header, string $key): bool => \in_array($key, self::REJECTED_HEADERS, true))
            ->map(static fn (array $header): string => $header[0])
            ->all();
    }
}
