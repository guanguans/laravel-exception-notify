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
use Illuminate\Support\Str;

class RequestPostCollector extends Collector
{
    protected \Illuminate\Http\Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collect(): array
    {
        return collect($this->request->post())
            ->transform(static function ($val, $key) {
                Str::is([
                    'password',
                    '*password',
                    'password*',
                ], $key) and $val = '******';

                return $val;
            })
            ->all();
    }
}
