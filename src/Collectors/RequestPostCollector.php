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
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class RequestPostCollector extends Collector
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * @noinspection MagicMethodsValidityInspection
     * @noinspection PhpMissingParentConstructorInspection
     */
    public function __construct(Request $request, callable $pipe = null)
    {
        $this->request = $request;
        $this->pipe = $pipe
            ?: static function (Collection $collection) {
                return $collection->transform(static function ($val, $key) {
                    /** @noinspection PhpParamsInspection */
                    Str::is([
                        'password',
                        '*password',
                        'password*',
                    ], $key) and $val = '******';

                    return $val;
                });
            };
    }

    public function collect()
    {
        return $this->request->post();
    }
}
