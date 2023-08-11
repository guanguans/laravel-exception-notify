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
use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Arr;
use Illuminate\Support\Manager;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\Tappable;

/**
 * @mixin \Guanguans\LaravelExceptionNotify\Contracts\ChannelContract
 */
class ExceptionNotifyManager extends Manager
{
    use Macroable {
        __call as macroCall;
    }
    use Tappable;

    /**
     * Handle dynamic method calls into the method.
     *
     * @param mixed $method
     * @param mixed $parameters
     */
    public function __call($method, $parameters)
    {
        if (static::hasMacro($method)) {
            return $this->macroCall($method, $parameters);
        }

        return parent::__call($method, $parameters);
    }

    /**
     * @param mixed $condition
     * @param array<string>|string $channels
     */
    public function reportIf($condition, \Throwable $throwable, $channels = null): void
    {
        value($condition) and $this->report($throwable, $channels);
    }

    /**
     * @param array<string>|string $channels
     */
    public function report(\Throwable $throwable, $channels = null): void
    {
        try {
            if ($this->shouldntReport($throwable)) {
                return;
            }

            $dispatch = dispatch(new ReportExceptionJob(
                app(CollectorManager::class)->mapToReports(
                    (array) ($channels ?? config('exception-notify.defaults')),
                    $throwable
                )
            ));

            if (
                ! $this->container->runningInConsole()
                && 'sync' === config('exception-notify.job.connection')
                && method_exists($dispatch, 'afterResponse')
            ) {
                $dispatch->afterResponse();
            }

            unset($dispatch);
        } catch (\Throwable $throwable) {
            app('log')->error($throwable->getMessage(), ['exception' => $throwable]);
        }
    }

    public function getDefaultDriver()
    {
        return Arr::first((array) config('exception-notify.defaults'));
    }

    protected function shouldntReport(\Throwable $throwable): bool
    {
        if (! config('exception-notify.enabled')) {
            return true;
        }

        if (! Str::is(config('exception-notify.env'), (string) $this->container->environment())) {
            return true;
        }

        if (Arr::first(config('exception-notify.except'), static fn (string $type): bool => $throwable instanceof $type)) {
            return true;
        }

        return ! $this->attempt(
            md5(implode('|', [
                $throwable->getFile(),
                $throwable->getLine(),
                $throwable->getCode(),
                $throwable->getTraceAsString(),
            ])),
            config('exception-notify.rate_limit.max_attempts'),
            config('exception-notify.rate_limit.decay_seconds')
        );
    }

    /**
     * @see RateLimiter::attempt
     */
    protected function attempt(string $key, int $maxAttempts, int $decaySeconds = 60): bool
    {
        if (app(RateLimiter::class)->tooManyAttempts($key, $maxAttempts)) {
            return false;
        }

        return tap(true, static function () use ($key, $decaySeconds): void {
            app(RateLimiter::class)->hit($key, $decaySeconds);
        });
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
}
