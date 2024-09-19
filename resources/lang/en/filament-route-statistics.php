<?php

return [
    'resources' => [
        'label' => 'Route Statistic',
        'plural_label' => 'Route Statistic',
    ],
    'table' => [
        'columns' => [
            'id' => 'ID',
            'user' => 'User',
            'team' => 'Team',
            'method' => 'Method',
            'route' => 'Route',
            'status' => 'Status',
            'ip' => 'I.P.',
            'date' => 'Date',
            'counter' => 'Counter',
        ]
    ],
    'filters' => [
        'date_from' => 'Date from',
        'date_to' => 'Date to',
    ],
    'widget' => [
        'description' => 'Number of requests'
    ]
];