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

namespace Guanguans\LaravelExceptionNotify\Collectors;

use Guanguans\LaravelExceptionNotify\Support\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Number;

class RequestBasicCollector extends AbstractCollector
{
    /** @var array<string, mixed> */
    private static array $appends = [];

    public function __construct(private readonly Request $request) {}

    /**
     * @param array<string, mixed> $appends
     */
    public static function mergeAppends(array $appends): void
    {
        self::$appends = array_merge(self::$appends, $appends);
    }

    /**
     * @throws \Exception
     *
     * @return array<string, mixed>
     */
    public function collect(): array
    {
        return array_merge([
            'URL' => $this->request->url(),
            'IP' => $this->request->ip(),
            'Method' => $this->request->method(),
            'Controller Action' => $this->request->route()?->getActionName(),
            'Command' => null,
            'Memory' => Number::fileSize(memory_get_peak_usage(true)),
            'Duration' => blank(
                $startTime = \defined('LARAVEL_START') ? LARAVEL_START : $this->request->server('REQUEST_TIME_FLOAT')
            ) ? 'Unknown' : Utils::humanMilliseconds((microtime(true) - (float) $startTime) * 1000),
        ], self::$appends);
    }
}
