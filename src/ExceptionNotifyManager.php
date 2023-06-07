<?php

declare(strict_types=1);

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
use Illuminate\Support\Arr;
use Illuminate\Support\Manager;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;
use Symfony\Component\RateLimiter\RateLimiterFactory;

class ExceptionNotifyManager extends Manager
{
    use Macroable {
        __call as macroCall;
    }

    /**
     * @var \Illuminate\Foundation\Application|\Illuminate\Contracts\Container\Container
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

    public function reportIf($condition, \Throwable $throwable): void
    {
        value($condition) and $this->report($throwable);
    }

    public function report(\Throwable $throwable): void
    {
        try {
            if ($this->shouldntReport($throwable)) {
                return;
            }

            $this->registerException($throwable);
            $this->dispatchReportExceptionJob();
        } catch (\Throwable $throwable) {
            $this->container['log']->error($throwable->getMessage(), ['exception' => $throwable]);
        }
    }

    protected function registerException(\Throwable $throwable): void
    {
        $this->container->instance('exception.notify.exception', $throwable);
    }

    protected function dispatchReportExceptionJob(): void
    {
        $report = (string) $this->container->make(CollectorManager::class);
        $drivers = $this->getDrivers() ?: Arr::wrap($this->driver());
        foreach ($drivers as $driver) {
            $dispatch = dispatch(ReportExceptionJob::create($driver, $report))
                ->onConnection($connection = $this->config->get('exception-notify.queue_connection'));

            if (! $this->container->runningInConsole() && 'sync' === $connection && method_exists($dispatch, 'afterResponse')) {
                $dispatch->afterResponse();
            }
        }
    }

    /** @noinspection MultipleReturnStatementsInspection */
    public function shouldntReport(\Throwable $throwable): bool
    {
        if (! $this->container['config']['exception-notify.enabled']) {
            return true;
        }

        if (! Str::is($this->container['config']['exception-notify.env'], (string) $this->container->environment())) {
            return true;
        }

        foreach ($this->container['config']['exception-notify.dont_report'] as $type) {
            if ($throwable instanceof $type) {
                return true;
            }
        }

        return ! $this
            ->container
            ->make(RateLimiterFactory::class)
            ->create(md5($throwable->getMessage().$throwable->getCode().$throwable->getFile().$throwable->getLine()))
            ->consume()
            ->isAccepted();
    }

    public function shouldReport(\Throwable $throwable): bool
    {
        return ! $this->shouldntReport($throwable);
    }

    protected function getChannelConfig($name): array
    {
        if (null !== $name && 'null' !== $name) {
            return $this->container['config']["exception-notify.channels.{$name}"];
        }

        return ['driver' => 'null'];
    }

    public function getDefaultDriver()
    {
        return $this->container['config']['exception-notify.default'];
    }

    /**
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

    protected function createBarkDriver(): BarkChannel
    {
        return new BarkChannel(
            Factory::bark(array_filter_filled([
                'token' => config('exception-notify.channels.bark.token'),
                'base_uri' => config('exception-notify.channels.bark.base_uri'),
            ]))
        );
    }

    protected function createChanifyDriver(): ChanifyChannel
    {
        return new ChanifyChannel(
            Factory::chanify(array_filter_filled([
                'token' => config('exception-notify.channels.chanify.token'),
                'base_uri' => config('exception-notify.channels.chanify.base_uri'),
            ]))
        );
    }

    protected function createDdDriver(): DdChannel
    {
        return new DdChannel();
    }

    protected function createDingTalkDriver(): DingTalkChannel
    {
        return new DingTalkChannel(
            Factory::dingTalk(array_filter_filled([
                'token' => config('exception-notify.channels.dingTalk.token'),
                'secret' => config('exception-notify.channels.dingTalk.secret'),
            ]))
        );
    }

    protected function createDiscordDriver(): DiscordChannel
    {
        return new DiscordChannel(
            Factory::discord(['webhook_url' => config('exception-notify.channels.discord.webhook_url')])
        );
    }

    protected function createDumpDriver(): DumpChannel
    {
        return new DumpChannel();
    }

    protected function createFeiShuDriver(): FeiShuChannel
    {
        return new FeiShuChannel(
            Factory::feiShu(array_filter_filled([
                'token' => config('exception-notify.channels.feiShu.token'),
                'secret' => config('exception-notify.channels.feiShu.secret'),
            ]))
        );
    }

    protected function createLogDriver(): LogChannel
    {
        return new LogChannel(
            config('exception-notify.channels.log.channel'),
            config('exception-notify.channels.log.level')
        );
    }

    protected function createMailDriver(): MailChannel
    {
        return new MailChannel(
            Factory::mailer(array_filter_filled([
                'dsn' => config('exception-notify.channels.mail.dsn'),
                'envelope' => config('exception-notify.channels.mail.envelope'),
            ]))
        );
    }

    protected function createNullDriver(): NullChannel
    {
        return new NullChannel();
    }

    protected function createPushDeerDriver(): PushDeerChannel
    {
        return new PushDeerChannel(
            Factory::pushDeer(array_filter_filled([
                'token' => config('exception-notify.channels.pushDeer.token'),
                'base_uri' => config('exception-notify.channels.pushDeer.base_uri'),
            ]))
        );
    }

    protected function createQqChannelBotDriver(): QqChannelBotChannel
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

    protected function createServerChanDriver(): ServerChanChannel
    {
        return new ServerChanChannel(
            Factory::serverChan(['token' => config('exception-notify.channels.serverChan.token')])
        );
    }

    protected function createSlackDriver(): SlackChannel
    {
        return new SlackChannel(
            Factory::slack(['webhook_url' => config('exception-notify.channels.slack.webhook_url')])
        );
    }

    protected function createTelegramDriver(): TelegramChannel
    {
        return new TelegramChannel(
            Factory::telegram(['token' => config('exception-notify.channels.telegram.token')])
        );
    }

    protected function createWeWorkDriver(): WeWorkChannel
    {
        return new WeWorkChannel(
            Factory::weWork(['token' => config('exception-notify.channels.weWork.token')])
        );
    }

    protected function createXiZhiDriver(): XiZhiChannel
    {
        return new XiZhiChannel(
            Factory::xiZhi([
                'token' => config('exception-notify.channels.xiZhi.token'),
                'type' => config('exception-notify.channels.xiZhi.type'),
            ])
        );
    }

    /**
     * Handle dynamic method calls into the method.
     *
     * @param string $method
     * @param array  $parameters
     */
    public function __call($method, $parameters)
    {
        if (static::hasMacro($method)) {
            return $this->macroCall($method, $parameters);
        }

        return $this->driver()->$method(...$parameters);
    }
}
