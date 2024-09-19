<?php

namespace Transistorizedcmd\RouteStatistics;

use Illuminate\Support\Facades\Facade;

class RouteStatisticsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'route-statistics';
    }
}