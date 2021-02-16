<?php

return [
    'sidebar' => [
        /**
         * Dashboard section
         */
        ':dashboard' => [
            'type' => 'header',
            'text' => 'DASHBOARD',
            'can' => 'backend.view',
        ],
        '/' => [
            'type' => 'item',
            'text' => 'Dashboard',
            'icon' => 'ion ion-ios-home',
            'can' => 'backend.view',
        ],
        /**
         * Manager section
         */
        ':manager' => [
            'type' => 'header',
            'text' => 'MANAGER',
            'can' => 'backend.admin',
        ],
        ':system' => [
            'type' => 'tree',
            'text' => 'System',
            'icon' => 'ion ion-ios-people',
            'can' => 'backend.admin',
            'items' => [
                '/users' => [
                    'type' => 'item',
                    'text' => 'Users',
                    'icon' => 'ion ion-ios-people',
                    'can' => 'user.view',
                ],
                '/roles' => [
                    'type' => 'item',
                    'text' => 'Roles',
                    'icon' => 'ion ion-ios-personadd',
                    'can' => 'role.view',
                ],
                '/perms' => [
                    'type' => 'item',
                    'text' => 'Perms',
                    'icon' => 'ion ion-ios-filing',
                    'can' => 'perm.view',
                ],
            ]
        ],
    ],

    'nav' => [

    ],    
];