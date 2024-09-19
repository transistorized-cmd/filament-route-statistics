<?php

namespace Transistorizedcmd\RouteStatistics;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class RouteStatisticsServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-route-statistics';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(self::$name)
            ->hasConfigFile(self::$name)
            ->hasTranslations()
            ->hasInstallCommand(function (InstallCommand $installCommand) {
                $installCommand
                    ->publishConfigFile()
                    ->askToStarRepoOnGitHub('transistorized-cmd/filament-route-statistics');
            });
    }
    
    public function register()
    {
        parent::register();

        $this->app->singleton('route-statistics', function ($app) {
            return new RouteStatisticsPlugin();
        });
    }
}
