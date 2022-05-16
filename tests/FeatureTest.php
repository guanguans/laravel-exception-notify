<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Tests;

class FeatureTest extends TestCase
{
    public function testReportException()
    {
        $response = $this->get('/report-exception');

        $response->assertSee('This is a test page.');
    }
}
