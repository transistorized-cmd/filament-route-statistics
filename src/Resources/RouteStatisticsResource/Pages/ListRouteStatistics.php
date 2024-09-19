<?php

namespace Transistorizedcmd\RouteStatistics\Resources\RouteStatisticsResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Transistorizedcmd\RouteStatistics\Resources\RouteStatisticsResource;
use Transistorizedcmd\RouteStatistics\Widgets\RouteStatisticsOverview;

class ListRouteStatistics extends ListRecords
{
    protected static string $resource = RouteStatisticsResource::class;

    protected function getHeaderWidgets(): array {
        return [
            RouteStatisticsOverview::class,
        ];
    }
}
