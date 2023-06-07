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

class RequestFileCollector extends Collector
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    public function __construct(Request $request, callable $pipe = null)
    {
        parent::__construct($pipe);
        $this->request = $request;
    }

    /**
     * @return mixed[]
     */
    public function collect()
    {
        $files = $this->request->allFiles();
        array_walk_recursive($files, static function (&$file): void {
            $file = [
                'name' => $file->getClientOriginalName(),
                'size' => $file->isFile() ? ($file->getSize() / 1000).'KB' : '0',
            ];
        });

        return $files;
    }
}
