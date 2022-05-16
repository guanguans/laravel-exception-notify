<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Tests\Collectors;

use Guanguans\LaravelExceptionNotify\Collectors\RequestSessionCollector;
use Guanguans\LaravelExceptionNotify\Tests\TestCase;

class RequestSessionCollectorTest extends TestCase
{
    public function testCollect()
    {
        $requestCookieCollector = new RequestSessionCollector($this->app['request']);
        $this->assertNull($requestCookieCollector->collect());
    }
}
