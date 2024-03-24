<?php

namespace Momotolabs\MhBiller\Tests;

use Momotolabs\Mhbiller\Providers\PackageServiceProvider;
use Orchestra\Testbench\TestCase;

class PackageTestCase extends TestCase
{
    protected $loadEnvironmentVariables = true;

    protected function getPackageProvider($app): array
    {
        return [
            PackageServiceProvider::class,
        ];
    }
}
