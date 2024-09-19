<?php

namespace Transistorizedcmd\RouteStatistics\Resources;

use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Transistorizedcmd\RouteStatistics\RouteStatisticsPlugin;
use Transistorizedcmd\RouteStatistics\Resources\RouteStatisticsResource\Pages\ListRouteStatistics;
use Bilfeldt\LaravelRouteStatistics\Models\RouteStatistic;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Transistorizedcmd\RouteStatistics\Widgets\RouteStatisticsOverview;

class RouteStatisticsResource extends Resource
{
    protected static string $userName = 'email';
    protected static string $dateFormat = 'M j, Y H:i';
    protected static string $default_sort_column = 'date';
    protected static string $default_sort_direction = 'desc';

    protected static ?RouteStatisticsPlugin $plugin = null;

    public static function getUserName(): string
    {
        return config('filament-route-statistics.username') ?? static::$userName;
    }
    
    public static function getModel(): string
    {
        return RouteStatistic::class;
    }

    public static function getDateFormat(): string
    {
        return config('filament-route-statistics.datetime_format') ?? static::$dateFormat;
    }
    
    public static function getModelLabel(): string
    {
        return static::getPlugin()->getLabel();
    }

    public static function getPluralModelLabel(): string
    {
        return static::getPlugin()->getPluralLabel();
    }

    public static function getNavigationIcon(): string
    {
        return static::getPlugin()->getNavigationIcon();
    }

    public static function getNavigationLabel(): string
    {
        return Str::title(static::getPluralModelLabel()) ?? Str::title(static::getModelLabel());
    }

    public static function getNavigationSort(): ?int
    {
        return static::getPlugin()->getNavigationSort();
    }

    public static function getNavigationGroup(): ?string
    {
        return static::getPlugin()->getNavigationGroup();
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getPlugin()->getNavigationCountBadge() ?
            number_format(static::getModel()::count()) : null;
    }

    public static function getSort(): string
    {
        return config('filament-route-statistics.resources.default_sort_column') ?? static::$default_sort_column;
    }

    public static function getSortDirection(): string
    {
        return config('filament-route-statistics.resources.default_sort_direction') ?? static::$default_sort_direction;
    }
    
    protected static function getPlugin(): RouteStatisticsPlugin
    {
        if (static::$plugin === null) {
            static::$plugin = app(RouteStatisticsPlugin::class);
        }
        return static::$plugin;
    }

    public static function setPlugin(RouteStatisticsPlugin $plugin): void
    {
        static::$plugin = $plugin;
    }
    
    public static function getWidgets(): array
    {
        return [
            RouteStatisticsOverview::class,
        ];
    }
    public static function getAggregate(): string
    {
        return config('route-statistics.aggregate');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->defaultSort(static::getSort(), static::getSortDirection())
            ->columns([
                TextColumn::make('id')
                    ->label(__('filament-route-statistics::filament-route-statistics.table.columns.id'))
                    ->sortable(),

                TextColumn::make('user.' . static::getUserName())
                    ->label(__('filament-route-statistics::filament-route-statistics.table.columns.user'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('method')
                    ->label(__('filament-route-statistics::filament-route-statistics.table.columns.method'))
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'GET' => 'success',
                        'POST' => 'warning',
                        'PUT' => 'info',
                        'PATCH' => 'gray',
                        'DELETE' => 'danger',
                        default => 'gray'
                    }),

                TextColumn::make('route')
                    ->label(__('filament-route-statistics::filament-route-statistics.table.columns.route'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('status')
                    ->label(__('filament-route-statistics::filament-route-statistics.table.columns.status'))
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): string => match (substr($state, 0, 1)) {
                        '1' => 'gray',
                        '2' => 'success',
                        '3' => 'info',
                        '4' => 'warning',
                        '5' => 'danger',
                        default => 'gray'
                    }),

                TextColumn::make('ip')
                    ->label(__('filament-route-statistics::filament-route-statistics.table.columns.ip'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('date')
                    ->label(__('filament-route-statistics::filament-route-statistics.table.columns.date'))
                    ->sortable()
                    ->searchable()
                    ->dateTime(static::getDateFormat()),

                TextColumn::make('counter')
                    ->label(__('filament-route-statistics::filament-route-statistics.table.columns.counter'))
                    ->sortable()
                    ->numeric(),
            ])
            ->filters([
                SelectFilter::make('method')
                    ->label(__('filament-route-statistics::filament-route-statistics.table.columns.method'))
                    ->multiple()
                    ->options(fn () => RouteStatistic::select('method')->distinct()->pluck('method', 'method'))
                    ->attribute('method'),

                SelectFilter::make('status')
                    ->label(__('filament-route-statistics::filament-route-statistics.table.columns.status'))
                    ->multiple()
                    ->options(fn () => RouteStatistic::select('status')->distinct()->pluck('status', 'status'))
                    ->attribute('status'),
                    
                Filter::make('date')
                    ->form(function () {
                        $time = static::getAggregate();
                        return [
                            DateTimePicker::make('created_from')
                                ->label(__('filament-route-statistics::filament-route-statistics.filters.date_from'))
                                ->time($time === 'MINUTE' || $time === 'HOUR')
                                ->seconds(false),
                            DateTimePicker::make('created_until')
                                ->label(__('filament-route-statistics::filament-route-statistics.filters.date_to'))
                                ->time($time === 'MINUTE'  || $time === 'HOUR')
                                ->seconds(false),
                        ];
                    })
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->where('date', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->where('date', '<=', $date),
                            );
                    })
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRouteStatistics::route('/'),
        ];
    }

    public static function canAccess(): bool
    {
        $policy = Gate::getPolicyFor(static::getModel());

        if ($policy && method_exists($policy, 'viewAny')) {
            return static::canViewAny();
        } else {
            return static::getPlugin()->isAuthorized();
        }
    }
}