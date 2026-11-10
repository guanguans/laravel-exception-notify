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

use Illuminate\Console\Events\CommandStarting;
use Illuminate\Console\Events\ScheduledTaskStarting;
use Illuminate\Console\Scheduling\CallbackEvent;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\ScheduleListCommand;
use Illuminate\Http\Request;
use Illuminate\Routing\Events\RouteMatched;
use Symfony\Component\Console\Input\ArgvInput;

/**
 * @method string getClosureLocation(CallbackEvent $event)
 */
final class CollectionSubscriber
{
    public const COMMAND = 'Command';
    public const IN_SCHEDULE = 'In Schedule';
    public const CONTROLLER_ACTION = 'Controller Action';

    /** @var array<string, mixed> */
    private array $collections = [];

    public function __construct(private readonly Request $request)
    {
        app()->instance(self::class, $this);
    }

    /**
     * @see \Illuminate\Database\Eloquent\Concerns\HasAttributes::mergeAppends()
     *
     * @api
     *
     * @return array<string, mixed>
     */
    public function getCollections(): array
    {
        return $this->collections; // @codeCoverageIgnore
    }

    public function getCommandCollection(): string
    {
        return $this->getCollection(self::COMMAND, Event::normalizeCommand((string) resolve(ArgvInput::class)));
    }

    public function getInScheduleCollection(): bool
    {
        return $this->getCollection(self::IN_SCHEDULE, false);
    }

    public function getControllerActionCollection(): string
    {
        return $this->getCollection(self::CONTROLLER_ACTION, $this->request->route()?->getActionName()); // @codeCoverageIgnore
    }

    /**
     * @api
     */
    public function getCollection(string $name, mixed $default = null): mixed
    {
        return $this->collections[$name] ?? $default;
    }

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
            CommandStarting::class => function (CommandStarting $commandStarting): void {
                $this->setCollection(self::COMMAND, Event::normalizeCommand((string) $commandStarting->input)); // @codeCoverageIgnore
            },
            RouteMatched::class => function (RouteMatched $routeMatched): void {
                $this->setCollection(self::CONTROLLER_ACTION, $routeMatched->route->getActionName());
            },
            ScheduledTaskStarting::class => function (ScheduledTaskStarting $scheduledTaskStarting): void {
                $this->setCollection(self::COMMAND, $this->resolveCommand($scheduledTaskStarting->task)); // @codeCoverageIgnore
                $this->setCollection(self::IN_SCHEDULE, true); // @codeCoverageIgnore
            },
        ];
    }

    private function setCollection(string $name, mixed $value): void
    {
        $this->collections[$name] = $value;
    }

    /**
     * @see \Illuminate\Console\Scheduling\ScheduleListCommand::displayJson()
     */
    private function resolveCommand(Event $schedulingEvent): string // @codeCoverageIgnoreStart
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
