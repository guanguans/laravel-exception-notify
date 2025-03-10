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

use ComposerUnused\ComposerUnused\Configuration\Configuration;
use ComposerUnused\ComposerUnused\Configuration\NamedFilter;
use ComposerUnused\ComposerUnused\Configuration\PatternFilter;

return static fn (Configuration $configuration): Configuration => $configuration
    // ->addNamedFilter(NamedFilter::fromString('symfony/config'))
    // ->addPatternFilter(PatternFilter::fromString('/symfony\/.*/'))
    ->setAdditionalFilesFor('icanhazstring/composer-unused', glob(__DIR__.'/{*,.*}.php', \GLOB_BRACE));
