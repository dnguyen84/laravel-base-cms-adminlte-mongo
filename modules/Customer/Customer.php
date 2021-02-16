<?php

return [
    'sidebar' => [
        ':system' => [
            'items' => [
                '/customers' => [
                    'type' => 'item',
                    'text' => 'Customers',
                    'icon' => 'ion ion-ios-gear',
                    'can' => 'customer.view',
                ],
            ]
        ]
    ], 
];