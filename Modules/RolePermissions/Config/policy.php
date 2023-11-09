<?php

return [
    'role' => [
        'user_group' => [
            'regular_user'
        ],

        'super_admin_group' => [
            'system_administrator',
        ],
        'developer_group' => [
            'programmer'
        ],
        'inspector_group' => [
            'inspector'
        ],
        'portal_group' => [
            'project_manager'
        ],
    ],
    'permission' => [
        'role' => [
            'index',
            'store',
            'update',
            'delete'
        ],
        'super_admin_group' => [
            'system_administrator',
        ],
        'permission' => [
            'index'
        ]
    ],
    'permission_role' => [
        'system_administrator' => ['*'],
        'programmer'           => ['*'],
        // 'regular_user'         => ['user'],
    ],
    'portal_permission_role' => [
        'project_manager' => ['*'],
    ],
];
