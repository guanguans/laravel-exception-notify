<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Tests\Collectors;

use Guanguans\LaravelExceptionNotify\Collectors\RequestServerCollector;
use Guanguans\LaravelExceptionNotify\Tests\TestCase;

class RequestServerCollectorTest extends TestCase
{
    public function testCollect(): void
    {
        $requestCookieCollector = new RequestServerCollector($this->app['request']);
        $this->assertIsArray($requestCookieCollector->collect());
    }
}
