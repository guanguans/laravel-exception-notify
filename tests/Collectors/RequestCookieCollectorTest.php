<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\LaravelExceptionNotify\Collectors\RequestCookieCollector;

it('collect', function (): void {
    $requestCookieCollector = new RequestCookieCollector($this->app['request']);
    expect($requestCookieCollector->collect())->toBeArray();
});
