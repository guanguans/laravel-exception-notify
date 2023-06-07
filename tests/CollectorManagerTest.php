<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Tests;

use Guanguans\LaravelExceptionNotify\CollectorManager;
use Guanguans\LaravelExceptionNotify\Exceptions\InvalidArgumentException;

/**
 * @internal
 *
 * @small
 */
class CollectorManagerTest extends TestCase
{
    private CollectorManager $collectorManager;

    protected function setUp(): void
    {
        parent::setUp();

        $this->collectorManager = $this->app->make(CollectorManager::class);
    }

    public function testOffsetSet(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->collectorManager->offsetSet('key', 'value');
    }
}
