<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection StaticClosureCanBeUsedInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2021-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

use Guanguans\LaravelExceptionNotify\Channels\AbstractChannel;
use Guanguans\LaravelExceptionNotify\Facades\ExceptionNotify;
use Guanguans\LaravelExceptionNotify\Pipes\AddKeywordChorePipe;
use Guanguans\LaravelExceptionNotify\Pipes\LimitLengthPipe;
use Guanguans\LaravelExceptionNotify\Pipes\SprintfMarkdownPipe;
use Illuminate\Http\UploadedFile;

it('can report exception', function (): void {
    $this
        ->post('report-exception?foo=bar', [
            'bar' => 'baz',
            'password' => 'password',
            'file' => new UploadedFile(__FILE__, basename(__FILE__)),
        ])
        ->assertOk();
})->group(__DIR__, __FILE__);

it('can auto report exception', function (): void {
    $this
        ->post('exception?foo=bar', [
            'bar' => 'baz',
            'password' => 'password',
            'file' => new UploadedFile(__FILE__, basename(__FILE__)),
        ])
        ->assertStatus(500);
})->group(__DIR__, __FILE__);

it('is a testing', function (): void {
    config()->set('exception-notify.channels.dingTalk', [
        'driver' => 'notify',
        'authenticator' => [
            'class' => Guanguans\Notify\DingTalk\Authenticator::class,
            'token' => 'string',
            'secret' => 'string',
            'secrets' => 'string',
        ],
        'client' => [
            'class' => Guanguans\Notify\DingTalk\Client::class,
            'http_options' => [
                'base_uri' => 'string',
                'timeout' => 10,
                'connect_timeout' => 10,
                'proxy' => 'string',
                'verify' => true,
                'cert_path' => 'string',
                'key_path' => 'string',
                'ca_path' => 'string',
                'ca_info' => 'string',
                'ssl_version' => 'string',
                'stream_context_options' => [],
            ],
        ],
        'message' => [
            'class' => Guanguans\Notify\DingTalk\Messages\MarkdownMessage::class,
            'options' => [
                'title' => AbstractChannel::TITLE_TEMPLATE,
                'text' => AbstractChannel::CONTENT_TEMPLATE,
            ],
            'title' => AbstractChannel::TITLE_TEMPLATE,
            'text' => AbstractChannel::CONTENT_TEMPLATE,
        ],
        'pipes' => [
            AddKeywordChorePipe::with('string'),
            SprintfMarkdownPipe::class,
            LimitLengthPipe::with(20000),
        ],
    ]);
    ExceptionNotify::driver('mail')->report(new Exception('This is a test exception.'));
})->group(__DIR__, __FILE__)->skip();
