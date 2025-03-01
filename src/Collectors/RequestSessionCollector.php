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

class RequestSessionCollector extends Collector
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collect(): array
    {
        return $this->request->hasSession() ? $this->request->session()->all() : [];
    }
}
