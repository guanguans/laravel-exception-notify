<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

use Guanguans\LaravelExceptionNotify\Exceptions\RuntimeException;
use Guanguans\LaravelExceptionNotify\Facades\ExceptionNotify;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', static fn () => view('welcome'));

Route::any(
    'proactive-report-exception',
    static fn () => tap(
        response('proactive-report-exception'),
        static function (): void {
            ExceptionNotify::report(new RuntimeException('What happened?'));
        }
    )
);

Route::any(
    'auto-report-exception',
    static function (Repository $repository): void {
        $repository->set('exception-notify.channels.stack.channels', [
            'dump',
            'log',
            'mail',
            'bark',
            'chanify',
            'dingTalk',
            'discord',
            'lark',
            'ntfy',
            'pushDeer',
            'slack',
            'telegram',
            'weWork',
        ]);

        throw new RuntimeException('What happened?');
    }
);
