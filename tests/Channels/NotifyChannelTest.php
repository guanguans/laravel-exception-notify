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
use Guanguans\LaravelExceptionNotify\Channels\DingTalkChannel;
use Guanguans\LaravelExceptionNotify\Channels\DiscordChannel;
use Guanguans\LaravelExceptionNotify\Channels\FeiShuChannel;
use Guanguans\LaravelExceptionNotify\Channels\PushDeerChannel;
use Guanguans\LaravelExceptionNotify\Channels\QqChannelBotChannel;
use Guanguans\LaravelExceptionNotify\Channels\ServerChanChannel;
use Guanguans\LaravelExceptionNotify\Channels\SlackChannel;
use Guanguans\LaravelExceptionNotify\Channels\TelegramChannel;
use Guanguans\LaravelExceptionNotify\Channels\WeWorkChannel;
use Guanguans\LaravelExceptionNotify\Channels\XiZhiChannel;
use Guanguans\LaravelExceptionNotify\ExceptionNotifyManager;
use Guanguans\Notify\Clients\Client;
use Guanguans\Notify\Contracts\MessageInterface;
use Illuminate\Notifications\Channels\MailChannel;
use Illuminate\Support\Str;

it('can report', function (): void {
    expect(new BarkChannel(
        Mockery::spy(Client::class)->allows('send')->once()->getMock()
    ))->report('report')->toBeNull();
})->group(__DIR__, __FILE__);

it('can create message', function (): void {
    $collection = collect([
        BarkChannel::class,
        ChanifyChannel::class,
        DingTalkChannel::class,
        DiscordChannel::class,
        FeiShuChannel::class,
        MailChannel::class,
        PushDeerChannel::class,
        QqChannelBotChannel::class,
        ServerChanChannel::class,
        SlackChannel::class,
        TelegramChannel::class,
        WeWorkChannel::class,
        XiZhiChannel::class,
    ])->transform(function (string $channelClass): MessageInterface {
        $channelName = (string) Str::of(class_basename($channelClass))
            ->beforeLast('Channel')
            ->lcfirst();

        $channel = $this
            ->app
            ->make(ExceptionNotifyManager::class)
            ->driver($channelName);

        return (fn () => $this->createMessage('report'))->call($channel);
    });

    expect($collection)->each->toBeInstanceOf(MessageInterface::class);
})->group(__DIR__, __FILE__);
