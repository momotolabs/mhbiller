<?php

declare(strict_types=1);

namespace Momotolabs\Mhbiller\Providers;

use Illuminate\Support\ServiceProvider;

final class PackageServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/biller.php' => config_path('biller.php'),
        ]);
        $this->mergeConfigFrom(
            __DIR__.'/../config/biller.php.php',
            'biller-mh'
        );

    }

    public function register()
    {
        config([
            'config/biller.php',
        ]);
    }
}
