<?php

namespace Codecourse\LaravelPopularity;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Codecourse\LaravelPopularity\Commands\LaravelPopularityCommand;

class LaravelPopularityServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-popularity')
            ->hasMigration('create_visits_table');
    }
}
