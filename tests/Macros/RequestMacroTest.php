<?php

/** @noinspection NullPointerExceptionInspection */

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

it('can get headers', function (): void {
    expect(request())
        ->headers()->toBeArray()
        ->headers('user-agent')->toBeString();
})->group(__DIR__, __FILE__);
