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

namespace Guanguans\LaravelExceptionNotify\Listeners;

use Guanguans\LaravelExceptionNotify\Collectors\RequestBasicCollector;
use Illuminate\Console\Events\CommandStarting;
use Illuminate\Console\Events\ScheduledTaskStarting;
use Illuminate\Console\Scheduling\CallbackEvent;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\ScheduleListCommand;
use Illuminate\Routing\Events\RouteMatched;

/**
 * @method string getClosureLocation(CallbackEvent $event)
 */
final class ContextSubscriber
{
    /**
     * @see \Symfony\Component\Console\DataCollector\CommandDataCollector
     * @see \Symfony\Component\Console\Debug\CliRequest
     * @see \Symfony\Component\Console\Command\TraceableCommand
     *
     * @api
     *
     * @return array<class-string, callable(object $event): void>
     */
    public function subscribe(): array
    {
        return [
            CommandStarting::class => static function (CommandStarting $commandStarting): void {
                RequestBasicCollector::mergeAppends([ // @codeCoverageIgnoreStart
                    // 'Command' => $commandStarting->command ?? $commandStarting->input->getArguments()['command'] ?? 'default',
                    // 'Command' => Event::normalizeCommand((string) $commandStarting->input),
                    'Command' => (string) $commandStarting->input,
                ]); // @codeCoverageIgnoreEnd
            },
            RouteMatched::class => static function (RouteMatched $routeMatched): void {
                RequestBasicCollector::mergeAppends(['Controller Action' => $routeMatched->route->getActionName()]);
            },
            ScheduledTaskStarting::class => static function (ScheduledTaskStarting $scheduledTaskStarting): void {
                RequestBasicCollector::mergeAppends(['Command' => self::resolveCommand($scheduledTaskStarting->task)]); // @codeCoverageIgnore
            },
        ];
    }

    /**
     * @see \Illuminate\Console\Scheduling\ScheduleListCommand::displayJson()
     */
    private static function resolveCommand(Event $schedulingEvent): string // @codeCoverageIgnoreStart
    {
        /**
         * @see \Illuminate\Console\Scheduling\Schedule::command()
         * @see \Illuminate\Console\Scheduling\Schedule::exec()
         */
        if ($schedulingEvent->command) {
            return Event::normalizeCommand($schedulingEvent->command);
        }

        /**
         * @see \Illuminate\Console\Scheduling\Schedule::call()
         * @see \Illuminate\Console\Scheduling\Schedule::job()
         */
        $command = Event::normalizeCommand($schedulingEvent->getSummaryForDisplay());

        if (!$schedulingEvent instanceof CallbackEvent || !\in_array($command, ['Callback', 'Closure'], true)) {
            return $command;
        }

        return 'Closure at: '.(fn () => $this->getClosureLocation($schedulingEvent))->call(
            tap(resolve(ScheduleListCommand::class))->setLaravel(app())
        );
    } // @codeCoverageIgnoreEnd
}
