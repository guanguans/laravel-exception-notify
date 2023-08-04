<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\LaravelExceptionNotify\Channels\BarkChannel;
use Guanguans\LaravelExceptionNotify\Channels\ChanifyChannel;
use Guanguans\LaravelExceptionNotify\Channels\DdChannel;
use Guanguans\LaravelExceptionNotify\Channels\DingTalkChannel;
use Guanguans\LaravelExceptionNotify\Channels\DiscordChannel;
use Guanguans\LaravelExceptionNotify\Channels\FeiShuChannel;
use Guanguans\LaravelExceptionNotify\Channels\MailChannel;
use Guanguans\LaravelExceptionNotify\Channels\NullChannel;
use Guanguans\LaravelExceptionNotify\Channels\PushDeerChannel;
use Guanguans\LaravelExceptionNotify\Channels\QqChannelBotChannel;
use Guanguans\LaravelExceptionNotify\Channels\ServerChanChannel;
use Guanguans\LaravelExceptionNotify\Channels\SlackChannel;
use Guanguans\LaravelExceptionNotify\Channels\TelegramChannel;
use Guanguans\LaravelExceptionNotify\Channels\WeWorkChannel;
use Guanguans\LaravelExceptionNotify\Channels\XiZhiChannel;
use Guanguans\LaravelExceptionNotify\ExceptionNotifyManager;
use Illuminate\Contracts\Container\Container;
use Nyholm\NSA;

beforeEach(function (): void {
    $this->exceptionNotifyManager = $this->app->make(ExceptionNotifyManager::class);
});

it('it can get the notify manager', function (): void {
    expect($this->exceptionNotifyManager)->toBeInstanceOf(ExceptionNotifyManager::class);
});

it('reportif', function (): void {
    expect($this->exceptionNotifyManager->reportIf(true, new Exception('test')))->toBeNull();
});

it('report', function (): void {
    $this->app['config']->set('exception-notify.enabled', false);
    expect($this->exceptionNotifyManager->report(new Exception('test')))->toBeNull();
    $this->app['config']->set('exception-notify.enabled', true);
});

it('shouldnt report', function (): void {
    $this->app['config']->set('exception-notify.enabled', false);
    expect($this->exceptionNotifyManager->shouldntReport($e = new Exception()))->toBeTrue();

    $this->app['config']->set('exception-notify.enabled', true);
    $this->app['config']->set('exception-notify.env', 'production');
    expect($this->exceptionNotifyManager->shouldntReport($e))->toBeTrue();

    $this->app['config']->set('exception-notify.enabled', true);
    $this->app['config']->set('exception-notify.env', '*');
    $this->app['config']->set('exception-notify.except', [Exception::class]);
    expect($this->exceptionNotifyManager->shouldntReport($e))->toBeTrue();

    $this->app['config']->set('exception-notify.enabled', true);
    $this->app['config']->set('exception-notify.env', '*');
    $this->app['config']->set('exception-notify.except', []);
    expect($this->exceptionNotifyManager->shouldntReport($e))->toBeFalse();
    // expect($this->exceptionNotifyManager->shouldReport($e))->toBeTrue();
});

it('get channel config', function (): void {
    $this->markTestSkipped(__METHOD__.': TODO');
    $channelConfig = NSA::invokeMethod($this->exceptionNotifyManager, 'getChannelConfig', 'null');
    expect($channelConfig)->toBeArray();
    expect($channelConfig)->toBe(['driver' => 'null']);

    $channelConfig = NSA::invokeMethod($this->exceptionNotifyManager, 'getChannelConfig', 'log');
    expect($channelConfig)->toBeArray();
    expect($this->app['config']->get('exception-notify.channels.log'))->toBe($channelConfig);
});

it('get default driver', function (): void {
    expect($defaultDriver = $this->exceptionNotifyManager->getDefaultDriver())->toBeString();
    expect($this->app['config']['exception-notify.default'])->toBe($defaultDriver);
});

it('get container', function (): void {
    $this->exceptionNotifyManager->setContainer($this->app->make(Container::class));
    expect($this->exceptionNotifyManager->getContainer())->toBeInstanceOf(Container::class);
});

it('forget drivers', function (): void {
    $this->exceptionNotifyManager->forgetDrivers();
    expect($this->exceptionNotifyManager->getDrivers())->toBeEmpty();
});

it('create bark driver', function (): void {
    $this->markTestSkipped(__METHOD__.': TODO');
    $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createBarkDriver');
    expect($driver)->toBeInstanceOf(BarkChannel::class);
});

it('create chanify driver', function (): void {
    $this->markTestSkipped(__METHOD__.': TODO');
    $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createChanifyDriver');
    expect($driver)->toBeInstanceOf(ChanifyChannel::class);
});

it('create dd driver', function (): void {
    $this->markTestSkipped(__METHOD__.': TODO');
    $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createDdDriver');
    expect($driver)->toBeInstanceOf(DdChannel::class);
});

it('create ding talk driver', function (): void {
    $this->markTestSkipped(__METHOD__.': TODO');
    $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createDingTalkDriver');
    expect($driver)->toBeInstanceOf(DingTalkChannel::class);
});

it('create discord driver', function (): void {
    $this->markTestSkipped(__METHOD__.': TODO');
    $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createDiscordDriver');
    expect($driver)->toBeInstanceOf(DiscordChannel::class);
});

it('create fei shu driver', function (): void {
    $this->markTestSkipped(__METHOD__.': TODO');
    $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createFeiShuDriver');
    expect($driver)->toBeInstanceOf(FeiShuChannel::class);
});

it('create mail driver', function (): void {
    $this->markTestSkipped(__METHOD__.': TODO');
    $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createMailDriver');
    expect($driver)->toBeInstanceOf(MailChannel::class);
});

it('create null driver', function (): void {
    $this->markTestSkipped(__METHOD__.': TODO');
    $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createNullDriver');
    expect($driver)->toBeInstanceOf(NullChannel::class);
});

it('create push deer driver', function (): void {
    $this->markTestSkipped(__METHOD__.': TODO');
    $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createPushDeerDriver');
    expect($driver)->toBeInstanceOf(PushDeerChannel::class);
});

it('create qq channel bot driver', function (): void {
    $this->markTestSkipped(__METHOD__.': TODO');
    $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createQqChannelBotDriver');
    expect($driver)->toBeInstanceOf(QqChannelBotChannel::class);
});

it('create server chan driver', function (): void {
    $this->markTestSkipped(__METHOD__.': TODO');
    $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createServerChanDriver');
    expect($driver)->toBeInstanceOf(ServerChanChannel::class);
});

it('create slack driver', function (): void {
    $this->markTestSkipped(__METHOD__.': TODO');
    $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createSlackDriver');
    expect($driver)->toBeInstanceOf(SlackChannel::class);
});

it('create telegram driver', function (): void {
    $this->markTestSkipped(__METHOD__.': TODO');
    $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createTelegramDriver');
    expect($driver)->toBeInstanceOf(TelegramChannel::class);
});

it('create we work driver', function (): void {
    $this->markTestSkipped(__METHOD__.': TODO');
    $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createWeWorkDriver');
    expect($driver)->toBeInstanceOf(WeWorkChannel::class);
});

it('create xi zhi driver', function (): void {
    $this->markTestSkipped(__METHOD__.': TODO');
    $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createXiZhiDriver');
    expect($driver)->toBeInstanceOf(XiZhiChannel::class);
});

it('call', function (): void {
    expect($this->exceptionNotifyManager->getDefaultDriver())->toBe($this->exceptionNotifyManager->name());
})->skip();
