<?php

declare(strict_types=1);

/**
 * Copyright (c) 2021-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

namespace Guanguans\LaravelExceptionNotify\Channels;

use Illuminate\Config\Repository;

abstract class Channel implements \Guanguans\LaravelExceptionNotify\Contracts\Channel
{
    protected Repository $config;

    public function __construct(Repository $config)
    {
        $this->config = $config;
    }
}
