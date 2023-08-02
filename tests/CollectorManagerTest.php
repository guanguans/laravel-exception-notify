<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\LaravelExceptionNotify\CollectorManager;
use Guanguans\LaravelExceptionNotify\Exceptions\InvalidArgumentException;

beforeEach(function (): void {
    $this->collectorManager = $this->app->make(CollectorManager::class);
});

it('offset set', function (): void {
    $this->expectException(InvalidArgumentException::class);
    $this->collectorManager->offsetSet('key', 'value');
});
