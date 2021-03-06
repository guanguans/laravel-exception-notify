<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Tests\Collectors;

use Guanguans\LaravelExceptionNotify\Collectors\RequestMiddlewareCollector;
use Guanguans\LaravelExceptionNotify\Tests\TestCase;

class RequestMiddlewareCollectorTest extends TestCase
{
    public function testCollect()
    {
        $requestCookieCollector = new RequestMiddlewareCollector($this->app['request']);
        $this->assertNull($requestCookieCollector->collect());
    }
}
