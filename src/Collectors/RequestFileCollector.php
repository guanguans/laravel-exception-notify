<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Collectors;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class RequestFileCollector extends Collector
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @noinspection CallableParameterUseCaseInTypeContextInspection
     */
    public function collect(): array
    {
        $files = $this->request->allFiles();

        array_walk_recursive($files, static function (UploadedFile &$file): void {
            $file = [
                'name' => $file->getClientOriginalName(),
                'size' => human_bytes($file->isFile() ? $file->getSize() : 0),
            ];
        });

        return $files;
    }
}
