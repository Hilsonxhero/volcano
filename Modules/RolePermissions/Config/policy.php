<?php

return [
    'role' => [
        'user_group' => [
            'regular_user'
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
    'permission_role' => [
        'system_administrator' => ['*'],
        'programmer'           => ['*'],
        // 'regular_user'         => ['user'],
    ]
];
