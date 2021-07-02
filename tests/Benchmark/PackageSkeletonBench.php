<?php

/**
 * This file is part of the guanguans/laravel-exception-notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelExceptionNotify\Tests\Benchmark;

use Guanguans\LaravelExceptionNotify\PackageSkeleton;

/**
 * @BeforeMethods({"setUp"})
 */
final class PackageSkeletonBench
{
    /**
     * @var \Guanguans\LaravelExceptionNotify\PackageSkeleton
     */
    private $packageSkeleton;

    public function setUp(): void
    {
        $this->packageSkeleton = new PackageSkeleton();
    }

    public function benchTest(): void
    {
        // $this->packageSkeleton->test();
        PackageSkeleton::test();
    }
}
