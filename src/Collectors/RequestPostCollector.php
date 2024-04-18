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
use Illuminate\Support\Str;

class RequestPostCollector extends Collector
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collect(): array
    {
        return collect($this->request->post())
            ->transform(static function ($value, $key) {
                if (Str::of($key)->is(['password', '*password', 'password*', '*password*'])) {
                    return '******';
                }

                return $value;
            })
            ->all();
    }
}
