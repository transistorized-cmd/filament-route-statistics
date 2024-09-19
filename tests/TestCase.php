<?php

namespace Transistorizedcmd\RouteStatistics\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Transistorizedcmd\RouteStatistics\RouteStatisticsServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            RouteStatisticsServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // Load the package configuration
        $configPath = __DIR__.'/../config/filament-route-statistics.php';
        if (file_exists($configPath)) {
            $config = require $configPath;
            $app['config']->set('filament-route-statistics', $config);
        }
    }

    protected function getConfigValue($key, $default = null)
    {
        $value = $this->app['config']->get("filament-route-statistics.{$key}", $default);
        
        return $value;
    }
}