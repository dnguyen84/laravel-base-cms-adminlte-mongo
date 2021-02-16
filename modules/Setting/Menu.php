<?php

return [
    'sidebar' => [
        ':system' => [
            'items' => [
                '/settings' => [
                    'type' => 'item',
                    'text' => 'Settings',
                    'icon' => 'ion ion-ios-gear',
                    'can' => 'setting.view',
                ],
            ]
        ]
    ], 
];