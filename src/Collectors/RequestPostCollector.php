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

class RequestPostCollector extends Collector
{
    private Request $request;
    private array $hiddenPatterns = [
        'password',
        '*password',
        'password*',
        '*password*',
    ];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collect(): array
    {
        return collect($this->request->post())
            ->transform(function ($value, string $key) {
                if (str($key)->is($this->hiddenPatterns)) {
                    return '******';
                }

                return $value;
            })
            ->all();
    }
}
