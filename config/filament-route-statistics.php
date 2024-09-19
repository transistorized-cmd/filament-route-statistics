<?php

return [
    'resources' => [
        'navigation_group' => 'System',
        'navigation_icon' => 'heroicon-o-chart-bar-square',
        'navigation_sort' => 190,
        'default_sort_column' => 'id',
        'default_sort_direction' => 'desc',
        'navigation_count_badge' => false,
        'resource' => \Transistorizedcmd\RouteStatistics\Resources\RouteStatisticsResource::class
    ],
    'datetime_format' => 'd/m/Y H:i:s',
    'username' => 'name'
];
