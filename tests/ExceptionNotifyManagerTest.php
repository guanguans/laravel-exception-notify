<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Tests;

use Exception;
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

class ExceptionNotifyManagerTest extends TestCase
{
    /**
     * @var ExceptionNotifyManager
     */
    private $exceptionNotifyManager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->exceptionNotifyManager = $this->app->make(ExceptionNotifyManager::class);
    }

    public function testItCanGetTheNotifyManager()
    {
        $this->assertInstanceOf(ExceptionNotifyManager::class, $this->exceptionNotifyManager);
    }

    public function testReportif()
    {
        $this->assertNull($this->exceptionNotifyManager->reportIf(true, new Exception('test')));
    }

    public function testReport()
    {
        $this->app['config']->set('exception-notify.enabled', false);
        $this->assertNull($this->exceptionNotifyManager->report(new Exception('test')));
        $this->app['config']->set('exception-notify.enabled', true);
    }

    public function testShouldntReport()
    {
        $this->app['config']->set('exception-notify.enabled', false);
        $this->assertTrue($this->exceptionNotifyManager->shouldntReport($e = new Exception()));

        $this->app['config']->set('exception-notify.enabled', true);
        $this->app['config']->set('exception-notify.env', 'production');
        $this->assertTrue($this->exceptionNotifyManager->shouldntReport($e));

        $this->app['config']->set('exception-notify.enabled', true);
        $this->app['config']->set('exception-notify.env', '*');
        $this->app['config']->set('exception-notify.dont_report', [Exception::class]);
        $this->assertTrue($this->exceptionNotifyManager->shouldntReport($e));

        $this->app['config']->set('exception-notify.enabled', true);
        $this->app['config']->set('exception-notify.env', '*');
        $this->app['config']->set('exception-notify.dont_report', []);
        $this->assertFalse($this->exceptionNotifyManager->shouldntReport($e));
        $this->assertTrue($this->exceptionNotifyManager->shouldReport($e));
    }

    public function testGetChannelConfig()
    {
        $channelConfig = NSA::invokeMethod($this->exceptionNotifyManager, 'getChannelConfig', 'null');
        $this->assertIsArray($channelConfig);
        $this->assertEquals($channelConfig, ['driver' => 'null']);

        $channelConfig = NSA::invokeMethod($this->exceptionNotifyManager, 'getChannelConfig', 'log');
        $this->assertIsArray($channelConfig);
        $this->assertEquals($channelConfig, $this->app['config']->get('exception-notify.channels.log'));
    }

    public function testGetDefaultDriver()
    {
        $this->assertIsString($defaultDriver = $this->exceptionNotifyManager->getDefaultDriver());
        $this->assertEquals($defaultDriver, $this->app['config']['exception-notify.default']);
    }

    public function testGetContainer()
    {
        $this->exceptionNotifyManager->setContainer($this->app->make(Container::class));
        $this->assertInstanceOf(Container::class, $this->exceptionNotifyManager->getContainer());
    }

    public function testForgetDrivers()
    {
        $this->exceptionNotifyManager->forgetDrivers();
        $this->assertEmpty($this->exceptionNotifyManager->getDrivers());
    }

    public function testCreateBarkDriver()
    {
        $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createBarkDriver');
        $this->assertInstanceOf(BarkChannel::class, $driver);
    }

    public function testCreateChanifyDriver()
    {
        $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createChanifyDriver');
        $this->assertInstanceOf(ChanifyChannel::class, $driver);
    }

    public function testCreateDdDriver()
    {
        $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createDdDriver');
        $this->assertInstanceOf(DdChannel::class, $driver);
    }

    public function testCreateDingTalkDriver()
    {
        $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createDingTalkDriver');
        $this->assertInstanceOf(DingTalkChannel::class, $driver);
    }

    public function testCreateDiscordDriver()
    {
        $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createDiscordDriver');
        $this->assertInstanceOf(DiscordChannel::class, $driver);
    }

    public function testCreateFeiShuDriver()
    {
        $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createFeiShuDriver');
        $this->assertInstanceOf(FeiShuChannel::class, $driver);
    }

    public function testCreateMailDriver()
    {
        $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createMailDriver');
        $this->assertInstanceOf(MailChannel::class, $driver);
    }

    public function testCreateNullDriver()
    {
        $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createNullDriver');
        $this->assertInstanceOf(NullChannel::class, $driver);
    }

    public function testCreatePushDeerDriver()
    {
        $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createPushDeerDriver');
        $this->assertInstanceOf(PushDeerChannel::class, $driver);
    }

    public function testCreateQqChannelBotDriver()
    {
        $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createQqChannelBotDriver');
        $this->assertInstanceOf(QqChannelBotChannel::class, $driver);
    }

    public function testCreateServerChanDriver()
    {
        $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createServerChanDriver');
        $this->assertInstanceOf(ServerChanChannel::class, $driver);
    }

    public function testCreateSlackDriver()
    {
        $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createSlackDriver');
        $this->assertInstanceOf(SlackChannel::class, $driver);
    }

    public function testCreateTelegramDriver()
    {
        $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createTelegramDriver');
        $this->assertInstanceOf(TelegramChannel::class, $driver);
    }

    public function testCreateWeWorkDriver()
    {
        $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createWeWorkDriver');
        $this->assertInstanceOf(WeWorkChannel::class, $driver);
    }

    public function testCreateXiZhiDriver()
    {
        $driver = NSA::invokeMethod($this->exceptionNotifyManager, 'createXiZhiDriver');
        $this->assertInstanceOf(XiZhiChannel::class, $driver);
    }

    public function testCall()
    {
        $this->assertEquals($this->exceptionNotifyManager->getName(), $this->exceptionNotifyManager->getDefaultDriver());
    }
}
