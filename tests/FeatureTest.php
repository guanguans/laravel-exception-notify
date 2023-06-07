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

/**
 * @internal
 *
 * @small
 */
class FeatureTest extends TestCase
{
    public function testReportException(): void
    {
        $logFile = $this->app['config']->get('logging.channels.single.path');
        file_exists($logFile) and unlink($logFile);

        $response = $this->get('/report-exception');
        $response->assertSee('This is an exception report test page.');

        $content = file_get_contents($logFile);
        $this->assertStringContainsString('What happened?', $content);

        collect($this->app->make(CollectorManager::class))
            ->each(function (Collector $collector) use ($content): void {
                $this->assertStringContainsString($collector->getName(), $content);
            });
    }

    public function testReport(): void
    {
        $this->markTestSkipped(__METHOD__);
        ob_start();
        exception_notify_report('What happened?', 'dump');
        $output = ob_get_clean(); // `echo` and `not afterResponse`

        $report = (string) $this->app->make(CollectorManager::class);
        $this->assertSame($report, $output);
        // $this->assertMatchesSnapshot($report);
    }
}
