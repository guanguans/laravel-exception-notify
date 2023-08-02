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
use Symfony\Component\HttpFoundation\Exception\SessionNotFoundException;

class RequestSessionCollector extends Collector
{
    protected \Illuminate\Http\Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collect(): array
    {
        try {
            return (array) optional($this->request->getSession())->all();
        } catch (SessionNotFoundException $sessionNotFoundException) {
            return [];
        }
    }
}
