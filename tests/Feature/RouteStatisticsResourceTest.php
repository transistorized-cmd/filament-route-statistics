<?php

namespace Transistorizedcmd\RouteStatistics\Tests\Feature;

use Transistorizedcmd\RouteStatistics\Resources\RouteStatisticsResource;
use Transistorizedcmd\RouteStatistics\Tests\TestCase;

class RouteStatisticsResourceTest extends TestCase
{
    public function test_get_model()
    {
        $model = RouteStatisticsResource::getModel();
        $this->assertEquals('Bilfeldt\LaravelRouteStatistics\Models\RouteStatistic', $model);
    }

    public function test_get_user_name()
    {
        $configuredUserName = $this->getConfigValue('username', 'email');
        $userName = RouteStatisticsResource::getUserName();
        
        $this->assertEquals($configuredUserName, $userName);
    }

    public function test_get_date_format()
    {
        $configuredDateFormat = $this->getConfigValue('datetime_format', 'M j, Y H:i');
        $dateFormat = RouteStatisticsResource::getDateFormat();

        $this->assertEquals($configuredDateFormat, $dateFormat);
    }

    public function test_get_model_label()
    {
        $configuredLabel = $this->getConfigValue('label', 'Route Statistic');
        $label = RouteStatisticsResource::getModelLabel();

        $this->assertIsString($configuredLabel, $label);
    }

    public function test_get_plural_model_label()
    {
        $configuredLabel = $this->getConfigValue('plural_label', 'Route Statistics');
        $label = RouteStatisticsResource::getPluralModelLabel();

        $this->assertIsString($configuredLabel, $label);
    }

    public function test_get_navigation_icon()
    {
        $configuredIcon = $this->getConfigValue('navigation_icon', 'heroicon-o-chart-bar-square');
        $icon = RouteStatisticsResource::getNavigationIcon();

        $this->assertIsString($configuredIcon, $icon);
    }

    public function test_get_navigation_label()
    {
        $configuredNavigationLabel = $this->getConfigValue('navigation_label', '');
        $navigationLabel = RouteStatisticsResource::getNavigationLabel();
        $this->assertIsString($configuredNavigationLabel, $navigationLabel);
    }

    public function test_get_navigation_sort()
    {
        $configuredNavigationSort = $this->getConfigValue('navigation_sort', 190);
        $sort = RouteStatisticsResource::getNavigationSort();
        $this->assertIsInt($configuredNavigationSort, $sort);
    }

    public function test_get_navigation_group()
    {
        $configuredNavigationGroup = $this->getConfigValue('navigation_group', 'System');
        $group = RouteStatisticsResource::getNavigationGroup();
        $this->assertIsString($configuredNavigationGroup, $group);
    }
    
    public function test_get_pages()
    {
        $pages = RouteStatisticsResource::getPages();
        $this->assertIsArray($pages);
        $this->assertArrayHasKey('index', $pages);
    }

    public function test_can_access()
    {
        $canAccess = RouteStatisticsResource::canAccess();
        $this->assertIsBool($canAccess);
    }
}