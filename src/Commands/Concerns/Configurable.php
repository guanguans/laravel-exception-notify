<?php

/** @noinspection MethodVisibilityInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2021-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/laravel-exception-notify
 */

namespace Guanguans\LaravelExceptionNotify\Commands\Concerns;

use Illuminate\Support\Collection;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @mixin \Illuminate\Console\Command
 */
trait Configurable
{
    public function getDefinition(): InputDefinition
    {
        return tap(parent::getDefinition(), static function (InputDefinition $inputDefinition): void {
            $inputDefinition->addOption(new InputOption(
                'configuration',
                null,
                InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY,
                'Used to dynamically pass one or more configuration key-value pairs(e.g. `--configuration=app.name=guanguans` or `--configuration app.name=guanguans`).',
            ));
        });
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        parent::initialize($input, $output);

        collect($this->option('configuration'))
            // ->dump()
            ->mapWithKeys(static function (string $configuration): array {
                \assert(
                    str_contains($configuration, '='),
                    "The configurable option [$configuration] must be formatted as key=value."
                );

                [$key, $value] = explode('=', $configuration, 2);

                return [$key => $value];
            })
            ->tap(static fn (Collection $configuration) => config($configuration->all()));
    }
}
