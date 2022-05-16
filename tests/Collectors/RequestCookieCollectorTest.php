<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Tests\Collectors;

use Guanguans\LaravelExceptionNotify\Collectors\RequestCookieCollector;
use Guanguans\LaravelExceptionNotify\Tests\TestCase;

class RequestCookieCollectorTest extends TestCase
{
    public function testCollect()
    {
        $requestCookieCollector = new RequestCookieCollector($this->app['request']);
        $this->assertIsArray($requestCookieCollector->collect());
    }
}
