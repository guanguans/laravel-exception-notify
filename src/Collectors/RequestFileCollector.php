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

namespace Guanguans\LaravelExceptionNotify\Collectors;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class RequestFileCollector extends Collector
{
    public function __construct(private Request $request) {}

    /**
     * @noinspection CallableParameterUseCaseInTypeContextInspection
     */
    public function collect(): array
    {
        $files = $this->request->allFiles();

        array_walk_recursive($files, static function (UploadedFile &$file): void {
            $file = [
                'name' => $file->getClientOriginalName(),
                'size' => \Guanguans\LaravelExceptionNotify\Support\human_bytes($file->isFile() ? $file->getSize() : 0),
            ];
        });

        return $files;
    }
}
