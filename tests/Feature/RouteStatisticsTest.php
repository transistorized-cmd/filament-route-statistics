<?php

use Transistorizedcmd\RouteStatistics\Resources\RouteStatisticsResource;
use Transistorizedcmd\RouteStatistics\RouteStatisticsPlugin;
use Bilfeldt\LaravelRouteStatistics\Models\RouteStatistic;

it('gets correct model', function () {
    expect(RouteStatisticsResource::getModel())->toBe(RouteStatistic::class);
});

it('can create route statistics plugin', function () {
    $plugin = RouteStatisticsPlugin::make();
    expect($plugin)->toBeInstanceOf(RouteStatisticsPlugin::class);
});

it('can get plugin id', function () {
    $plugin = RouteStatisticsPlugin::make();
    expect($plugin->getId())->toBe('transistorized-cmd/filament-route-statistics');
});

it('can authorize plugin', function () {
    $plugin = RouteStatisticsPlugin::make()->authorize(true);
    expect($plugin->isAuthorized())->toBeTrue();

    $plugin = RouteStatisticsPlugin::make()->authorize(false);
    expect($plugin->isAuthorized())->toBeFalse();
});