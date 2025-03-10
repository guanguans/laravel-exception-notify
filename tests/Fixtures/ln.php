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

use Illuminate\Console\OutputStyle;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Process\Process;

require __DIR__.'/../../vendor/autoload.php';

$process = new Process([
    // 'ln', '-sf', $dir = __DIR__.'/../../vendor/orchestra/testbench-core/laravel/', basename($dir),
    'ln', '-sf', $dir = __DIR__.'/../../vendor/laravel/framework/src/Illuminate/', basename($dir),
]);

$outputStyle = new OutputStyle(new ArgvInput, new ConsoleOutput);

$process->mustRun(static function ($type, $buffer) use ($outputStyle): void {
    $outputStyle->write($buffer);
});

$outputStyle->success('ok');
