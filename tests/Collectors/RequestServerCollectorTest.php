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

/**
 * @internal
 *
 * @small
 */
class RequestServerCollectorTest extends TestCase
{
    public function testCollect(): void
    {
        $requestServerCollector = new RequestServerCollector($this->app['request']);
        $this->assertIsArray($requestServerCollector->collect());
    }
}
