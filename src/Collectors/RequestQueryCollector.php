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

use Illuminate\Http\Request;

class RequestQueryCollector extends Collector
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @psalm-suppress InvalidReturnType
     * @psalm-suppress InvalidReturnStatement
     * @psalm-suppress NullableReturnStatement
     * @psalm-suppress InvalidNullableReturnType
     */
    public function collect(): array
    {
        return $this->request->query();
    }
}
