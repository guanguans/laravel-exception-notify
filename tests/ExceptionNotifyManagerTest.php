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

/**
 * @internal
 *
 * @small
 */
class ExceptionNotifyManagerTest extends TestCase
{
    private ExceptionNotifyManager $exceptionNotifyManager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->exceptionNotifyManager = $this->app->make(ExceptionNotifyManager::class);
    }

    public function testItCanGetTheNotifyManager(): void
    {
        $this->assertInstanceOf(ExceptionNotifyManager::class, $this->exceptionNotifyManager);
    }

    public function testReportif(): void
    {
        $this->assertNull($this->exceptionNotifyManager->reportIf(true, new \Exception('test')));
    }

    public function testReport(): void
    {
        $this->app['config']->set('exception-notify.enabled', false);
        $this->assertNull($this->exceptionNotifyManager->report(new \Exception('test')));
        $this->app['config']->set('exception-notify.enabled', true);
    }

    public function testShouldntReport(): void
    {
        $this->app['config']->set('exception-notify.enabled', false);
        $this->assertTrue($this->exceptionNotifyManager->shouldntReport($e = new \Exception()));

        $this->app['config']->set('exception-notify.enabled', true);
        $this->app['config']->set('exception-notify.env', 'production');
        $this->assertTrue($this->exceptionNotifyManager->shouldntReport($e));

        $this->app['config']->set('exception-notify.enabled', true);
        $this->app['config']->set('exception-notify.env', '*');
        $this->app['config']->set('exception-notify.dont_report', [\Exception::class]);
        $this->assertTrue($this->exceptionNotifyManager->shouldntReport($e));

        $this->app['config']->set('exception-notify.enabled', true);
        $this->app['config']->set('exception-notify.env', '*');
        $this->app['config']->set('exception-notify.dont_report', []);
        $this->assertFalse($this->exceptionNotifyManager->shouldntReport($e));
        $this->assertTrue($this->exceptionNotifyManager->shouldReport($e));
    }

    public function testGetChannelConfig(): void
    {
        $channelConfig = NSA::invokeMethod($this->exceptionNotifyManager, 'getChannelConfig', 'null');
        $this->assertIsArray($channelConfig);
        $this->assertSame(['driver' => 'null'], $channelConfig);

        $channelConfig = NSA::invokeMethod($this->exceptionNotifyManager, 'getChannelConfig', 'log');
        $this->assertIsArray($channelConfig);
        $this->assertSame($channelConfig, $this->app['config']->get('exception-notify.channels.log'));
    }

    public function testGetDefaultDriver(): void
    {
        $this->assertIsString($defaultDriver = $this->exceptionNotifyManager->getDefaultDriver());
        $this->assertSame($defaultDriver, $this->app['config']['exception-notify.default']);
    }

    public function testGetContainer(): void
    {
        $this->exceptionNotifyManager->setContainer($this->app->make(Container::class));
        $this->assertInstanceOf(Container::class, $this->exceptionNotifyManager->getContainer());
    }

    public function testForgetDrivers(): void
    {
        $this->exceptionNotifyManager->forgetDrivers();
        $this->assertEmpty($this->exceptionNotifyManager->getDrivers());
    }

    public function testCreateBarkDriver(): void
    {
        $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createBarkDriver');
        $this->assertInstanceOf(BarkChannel::class, $driver);
    }

    public function testCreateChanifyDriver(): void
    {
        $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createChanifyDriver');
        $this->assertInstanceOf(ChanifyChannel::class, $driver);
    }

    public function testCreateDdDriver(): void
    {
        $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createDdDriver');
        $this->assertInstanceOf(DdChannel::class, $driver);
    }

    public function testCreateDingTalkDriver(): void
    {
        $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createDingTalkDriver');
        $this->assertInstanceOf(DingTalkChannel::class, $driver);
    }

    public function testCreateDiscordDriver(): void
    {
        $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createDiscordDriver');
        $this->assertInstanceOf(DiscordChannel::class, $driver);
    }

    public function testCreateFeiShuDriver(): void
    {
        $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createFeiShuDriver');
        $this->assertInstanceOf(FeiShuChannel::class, $driver);
    }

    public function testCreateMailDriver(): void
    {
        $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createMailDriver');
        $this->assertInstanceOf(MailChannel::class, $driver);
    }

    public function testCreateNullDriver(): void
    {
        $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createNullDriver');
        $this->assertInstanceOf(NullChannel::class, $driver);
    }

    public function testCreatePushDeerDriver(): void
    {
        $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createPushDeerDriver');
        $this->assertInstanceOf(PushDeerChannel::class, $driver);
    }

    public function testCreateQqChannelBotDriver(): void
    {
        $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createQqChannelBotDriver');
        $this->assertInstanceOf(QqChannelBotChannel::class, $driver);
    }

    public function testCreateServerChanDriver(): void
    {
        $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createServerChanDriver');
        $this->assertInstanceOf(ServerChanChannel::class, $driver);
    }

    public function testCreateSlackDriver(): void
    {
        $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createSlackDriver');
        $this->assertInstanceOf(SlackChannel::class, $driver);
    }

    public function testCreateTelegramDriver(): void
    {
        $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createTelegramDriver');
        $this->assertInstanceOf(TelegramChannel::class, $driver);
    }

    public function testCreateWeWorkDriver(): void
    {
        $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createWeWorkDriver');
        $this->assertInstanceOf(WeWorkChannel::class, $driver);
    }

    public function testCreateXiZhiDriver(): void
    {
        $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createXiZhiDriver');
        $this->assertInstanceOf(XiZhiChannel::class, $driver);
    }

    public function testCall(): void
    {
        $this->assertSame($this->exceptionNotifyManager->getName(), $this->exceptionNotifyManager->getDefaultDriver());
    }
}
