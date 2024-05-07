<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection StaticClosureCanBeUsedInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2021-2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

use Guanguans\LaravelExceptionNotify\Channels\NotifyChannel;
use Guanguans\LaravelExceptionNotify\ExceptionNotifyManager;
use Guanguans\Notify\Foundation\Client;
use GuzzleHttp\Psr7\HttpFactory;
use Illuminate\Config\Repository;
use Psr\Http\Message\ResponseInterface;

it('will throw `InvalidArgumentException`', function (): void {
    new NotifyChannel(new Repository([
        'client' => [
            'extender' => null,
        ],
    ]));
})->group(__DIR__, __FILE__)->throws(\Guanguans\LaravelExceptionNotify\Exceptions\InvalidArgumentException::class);

it('can report', function (): void {
    config()->set('exception-notify.channels.bark.authenticator.token', 'token');
    config()->set('exception-notify.channels.bark.client.extender', static fn (Client $client): Client => $client->mock([
        (new HttpFactory)->createResponse(200, '{"code":200,"message":"success","timestamp":1708331409}'),
    ]));

    expect($this->app->make(ExceptionNotifyManager::class)->driver('bark'))
        ->report('report')
        ->toBeInstanceOf(ResponseInterface::class);
})->group(__DIR__, __FILE__);
