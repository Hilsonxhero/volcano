<?php

return [
    // List Of Roles
    'role' => [
        'user_group' => [
            'regular_user'
        ],
        'manager_group' => [
            'resource_manager',
            'project_manager',
            'account_manager',
            'team_manager',
            'communications_manager',
            'marketing_manager'
        ],
        'super_admin_group' => [
            'system_administrator'
        ],
        'developer_group' => [
            'programmer'
        ],
        'inspector_group' => [
            'inspector'
        ]
    ],
    // List Of Permissions
    'permission' => [
        'role' => [
            'index',
            'store',
            'update',
            'delete'
        ],
        'permission' => [
            'index'
        ]
    ],
    // Sync Permissions To Role
    'permission_role' => [
        'system_administrator' => ['*'],
        'programmer'           => ['*'],
        'regular_user'         => ['user'],
    ]
];
