<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Tests;

use Guanguans\LaravelExceptionNotify\CollectorManager;
use Guanguans\LaravelExceptionNotify\Contracts\Collector;

class FeatureTest extends TestCase
{
    public function testReportException(): void
    {
        $response = $this->get('/report-exception');
        $response->assertSee('This is a test page.');

        $logPath = $this->app['config']->get('logging.channels.single.path');
        $content = file_get_contents($logPath);
        $this->assertStringContainsString('What happened?', $content);
        collect($this->app->make(CollectorManager::class))
            ->each(function (Collector $collector) use ($content): void {
                $this->assertStringContainsString($collector->getName(), $content);
            });
    }

    public function testReport()
    {
        $this->markTestSkipped(__METHOD__);

        exception_notify_report('What happened?', 'dump');
        $report = (string) $this->app->make(CollectorManager::class);
        $this->assertMatchesSnapshot($report);
        // $this->expectOutputString($report);
    }
}
