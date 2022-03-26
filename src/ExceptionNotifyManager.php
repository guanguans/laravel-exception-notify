<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify;

use Guanguans\LaravelExceptionNotify\Channels\BarkChannel;
use Guanguans\LaravelExceptionNotify\Channels\ChanifyChannel;
use Guanguans\LaravelExceptionNotify\Channels\DdChannel;
use Guanguans\LaravelExceptionNotify\Channels\DingTalkChannel;
use Guanguans\LaravelExceptionNotify\Channels\DiscordChannel;
use Guanguans\LaravelExceptionNotify\Channels\DumpChannel;
use Guanguans\LaravelExceptionNotify\Channels\FeiShuChannel;
use Guanguans\LaravelExceptionNotify\Channels\LogChannel;
use Guanguans\LaravelExceptionNotify\Channels\MailChannel;
use Guanguans\LaravelExceptionNotify\Channels\NullChannel;
use Guanguans\LaravelExceptionNotify\Channels\PushDeerChannel;
use Guanguans\LaravelExceptionNotify\Channels\QqChannelBotChannel;
use Guanguans\LaravelExceptionNotify\Channels\ServerChanChannel;
use Guanguans\LaravelExceptionNotify\Channels\SlackChannel;
use Guanguans\LaravelExceptionNotify\Channels\TelegramChannel;
use Guanguans\LaravelExceptionNotify\Channels\WeWorkChannel;
use Guanguans\LaravelExceptionNotify\Channels\XiZhiChannel;
use Guanguans\LaravelExceptionNotify\Jobs\ReportExceptionJob;
use Guanguans\Notify\Factory;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Arr;
use Illuminate\Support\Manager;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;
use Throwable;

class ExceptionNotifyManager extends Manager
{
    use Macroable {
        __call as macroCall;
    }

    /**
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $container;

    /**
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    public function __construct(Container $container)
    {
        // 版本兼容
        parent::__construct($container);
        $this->container = $container;
        $this->config = $container->make('config');
    }

    public function reportIf($condition, Throwable $e)
    {
        $condition and $this->report($e);
    }

    public function report(Throwable $e)
    {
        try {
            if ($this->shouldntReport($e)) {
                return;
            }

            $this->registerException($e);
            $this->registerReportExceptionJobMethod();
            $this->dispatchReportExceptionJob();
        } catch (Throwable $e) {
            $this->container['log']->error($e->getMessage(), ['exception' => $e]);
        }
    }

    protected function registerException(Throwable $e)
    {
        $this->container->instance('exception.notify.exception', $e);
    }

    protected function registerReportExceptionJobMethod()
    {
        $this->container->bindMethod(
            sprintf('%s@handle', ReportExceptionJob::class),
            function (ShouldQueue $job, Container $container) {
                $report = (string) $container->make(CollectorManager::class);

                return $job->handle($report);
            }
        );
    }

    protected function dispatchReportExceptionJob()
    {
        $drivers = $this->getDrivers() ?: Arr::wrap($this->driver());
        foreach ($drivers as $driver) {
            $dispatch = dispatch(ReportExceptionJob::create($driver));

            'sync' === $this->container['config']['queue.default'] and
            method_exists($dispatch, 'afterResponse') and $dispatch->afterResponse();
        }
    }

    public function shouldntReport(Throwable $e): bool
    {
        if (! $this->container['config']['exception-notify.enabled']) {
            return true;
        }

        if (! Str::is($this->container['config']['exception-notify.env'], $this->container->environment())) {
            return true;
        }

        foreach ($this->container['config']['exception-notify.dont_report'] as $type) {
            if ($e instanceof $type) {
                return true;
            }
        }

        return false;
    }

    public function shouldReport(Throwable $e): bool
    {
        return ! $this->shouldntReport($e);
    }

    /**
     * @param $name
     *
     * @return array
     */
    protected function getClientOptions($name)
    {
        $options = $this->transformConfigToOptions($this->getChannelConfig($name));

        return array_filter($options, function ($option) {
            return ! blank($option);
        });
    }

    /**
     * @return array
     */
    protected function transformConfigToOptions(array $config)
    {
        unset(
            $config['keyword'],
            $config['driver'],
            $config['pipeline'],
            $config['to'],
            $config['from'],
            $config['url'],
            $config['group'],
            $config['copy'],
            $config['url'],
            $config['icon'],
            $config['group'],
            $config['level'],
            $config['badge'],
            $config['isArchive'],
            $config['autoCopy'],
            $config['automaticallyCopy'],
        );

        return $config;
    }

    /**
     * @param $name
     *
     * @return array
     */
    protected function getChannelConfig($name)
    {
        if (! is_null($name) && 'null' !== $name) {
            return $this->container['config']["exception-notify.channels.$name"];
        }

        return ['driver' => 'null'];
    }

    public function getDefaultDriver()
    {
        return $this->container['config']['exception-notify.default'];
    }

    /**
     * @param ...$channels
     *
     * @return $this
     */
    public function onChannel(...$channels)
    {
        foreach ($channels as $channel) {
            $this->driver($channel);
        }

        return $this;
    }

    public function getContainer()
    {
        return $this->container;
    }

    public function setContainer(Container $container)
    {
        $this->container = $container;

        return $this;
    }

    public function forgetDrivers()
    {
        $this->drivers = [];

        return $this;
    }

    protected function createBarkDriver()
    {
        return new BarkChannel(
            Factory::bark(array_filter_filled([
                'token' => config('exception-notify.channels.bark.token'),
                'base_uri' => config('exception-notify.channels.bark.base_uri'),
            ]))
        );
    }

    protected function createChanifyDriver()
    {
        return new ChanifyChannel(
            Factory::chanify(array_filter_filled([
                'token' => config('exception-notify.channels.chanify.token'),
                'base_uri' => config('exception-notify.channels.chanify.base_uri'),
            ]))
        );
    }

    protected function createDingTalkDriver()
    {
        return new DingTalkChannel(
            Factory::dingTalk($this->getClientOptions('dingTalk'))
        );
    }

    protected function createDiscordDriver()
    {
        return new DiscordChannel(
            Factory::discord(['webhook_url' => config('exception-notify.channels.discord.webhook_url')])
        );
    }

    protected function createDdDriver()
    {
        return new DdChannel();
    }

    protected function createDumpDriver()
    {
        return new DumpChannel();
    }

    protected function createFeiShuDriver()
    {
        return new FeiShuChannel(
            Factory::feiShu($this->getClientOptions('feiShu'))
        );
    }

    protected function createLogDriver()
    {
        return new LogChannel(config('exception-notify.default.channels.log.level', 'info'));
    }

    protected function createMailDriver()
    {
        return new MailChannel(
            Factory::mailer($this->getClientOptions('mail'))
        );
    }

    protected function createNullDriver()
    {
        return new NullChannel();
    }

    protected function createPushDeerDriver()
    {
        return new PushDeerChannel(
            Factory::pushDeer($this->getClientOptions('pushDeer'))
        );
    }

    protected function createQqChannelBotDriver()
    {
        return new QqChannelBotChannel(
            Factory::qqChannelBot(array_filter_filled([
                'appid' => config('exception-notify.channels.qqChannelBot.appid'),
                'token' => config('exception-notify.channels.qqChannelBot.token'),
                'secret' => config('exception-notify.channels.qqChannelBot.secret'),
                'environment' => config('exception-notify.channels.qqChannelBot.environment'),
                'channel_id' => config('exception-notify.channels.qqChannelBot.channel_id'),
            ]))
        );
    }

    protected function createServerChanDriver()
    {
        return new ServerChanChannel(
            Factory::serverChan($this->getClientOptions('serverChan'))
        );
    }

    protected function createSlackDriver()
    {
        return new SlackChannel(
            Factory::slack(['webhook_url' => config('exception-notify.channels.slack.webhook_url')])
        );
    }

    protected function createTelegramDriver()
    {
        return new TelegramChannel(
            Factory::telegram(['token' => config('exception-notify.channels.telegram.token')])
        );
    }

    protected function createWeWorkDriver()
    {
        return new WeWorkChannel(
            Factory::weWork($this->getClientOptions('weWork'))
        );
    }

    protected function createXiZhiDriver()
    {
        return new XiZhiChannel(
            Factory::xiZhi($this->getClientOptions('xiZhi'))
        );
    }

    /**
     * Handle dynamic method calls into the method.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (static::hasMacro($method)) {
            return $this->macroCall($method, $parameters);
        }

        return $this->driver()->$method(...$parameters);
    }
}
