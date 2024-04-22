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

namespace Guanguans\LaravelExceptionNotify\Channels;

use Guanguans\LaravelExceptionNotify\Contracts\ChannelContract;
use Guanguans\LaravelExceptionNotify\Facades\ExceptionNotify;
use Illuminate\Config\Repository;

class AggregateChannel implements ChannelContract
{
    public const NAME = 'aggregate';
    private Repository $config;

    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    public function report(string $report): void
    {
        collect($this->config->get('channels', []))
            ->reject(static function (string $channel): bool {
                $config = config("exception-notify.channels.$channel", []);

                return self::NAME === ($config['driver'] ?? $channel);
            })
            ->each(static function (string $channel) use ($report): void {
                ExceptionNotify::driver($channel)->report($report);
            });
    }
}
