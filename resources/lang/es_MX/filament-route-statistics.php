<?php

return [
    'resources' => [
        'label' => 'Estadísticas de rutas',
        'plural_label' => 'Estadística de ruta',
    ],
    'table' => [
        'columns' => [
            'id' => 'ID',
            'user' => 'Usuario',
            'team' => 'Equipo',
            'method' => 'Método',
            'route' => 'Ruta',
            'status' => 'Estatus',
            'ip' => 'I.P.',
            'date' => 'Fecha',
            'counter' => 'Contador',
        ]
    ],
    'filters' => [
        'date_from' => 'Fecha desde',
        'date_to' => 'Fecha hasta',
    ],
    'widget' => [
        'description' => 'Número de peticiones'
    ]
];