<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2024 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
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
})->group(__DIR__, __FILE__)->skip();

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
})->group(__DIR__, __FILE__)->skip();
