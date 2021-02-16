<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Define menu navigation for publisher
    |--------------------------------------------------------------------------
    */

    'publisher' => [
        /**
         * Dashboard section
         */
         ':dashboard' => [
            'type' => 'header',
            'text' => 'PUBLISHER',
            'can' => 'backend.view',
        ],
        '/p/{id}' => [
            'type' => 'item',
            'text' => 'Dashboard',
            'icon' => 'ion ion-ios-home',
            'can' => 'backend.view',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Define menu navigation for backend
    |--------------------------------------------------------------------------
    */
    'backend' => [
        /**
         * Dashboard section
         */
        ':dashboard' => [
            'type' => 'header',
            'text' => 'UserMet CMS',
            'can' => 'backend.view',
        ],
        '/' => [
            'type' => 'item',
            'text' => 'Dashboard',
            'icon' => 'ion ion-ios-home',
            'can' => 'backend.view',
        ],


        /**
         * Marketing section
         */
        ':Marketing' => [
            'type' => 'header',
            'text' => 'Marketing',
            'can' => 'backend.view',
        ],
        '/customers' => [
            'type' => 'item',
            'text' => 'Customers',
            'icon' => 'ion ion-ios-people-outline',
            'can' => 'backend.view',
        ],

        /**
         * Manager section
         */
        ':manager' => [
            'type' => 'header',
            'text' => 'MANAGER',
            'can' => 'backend.view',
        ],
        ':management' => [
            'type' => 'tree',
            'text' => 'System',
            'icon' => 'ion ion-ios-people',
            'can' => 'backend.view',
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
                '/settings' => [
                    'type' => 'item',
                    'text' => 'Settings',
                    'icon' => 'ion ion-ios-cog-outline',
                    'can' => 'setting.view',
                ],
            ]
        ],
        /**
         * E-commerce config sections
         */
        ':config' => [
            'type' => 'tree',
            'text' => 'Settings',
            'icon' => 'ion ion-ios-cog',
            'can' => 'backend.admin',
            'items' => [
                '/settings' => [
                    'type' => 'item',
                    'text' => 'Settings',
                    'icon' => 'ion ion-ios-gear',
                    'can' => 'setting.view',
                ],
            ]
        ],
    ],
];
