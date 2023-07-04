<?php

return [
    // List Of Permissions
    'permission' => [
        'role' => [
            'parent'                 => '👥 Role Access Permissions',
            'index'                  => '📜 View Roles',
            'store'                  => '🆕 Create Role',
            'update'                 => '✏️ Edit Role Details',
            'delete'                 => '🗑️ Delete Role',
        ],
        'permission' => [
            'parent'                 => '🔒 Permission Access Permissions',
            'index'                  => '📜 View Permissions'
        ],
    ],
    // List Of Roles
    'role' => [
        'user_group'       => [
            'parent'                 => '👤 User Group',
            'regular_user'           => '🙂 Regular User'
        ],
        'manager_group'    => [
            'parent'                 => '🧑‍💼 Manager Group',
            'resource_manager'       => '🤝 Resource Manager',
            'project_manager'        => '📈 Project Manager',
            'account_manager'        => '💰 Account Manager',
            'team_manager'           => '👥 Team Manager',
            'communications_manager' => '📞 Communications Manager',
            'marketing_manager'      => '📣 Marketing Manager'
        ],
        'super_admin_group' => [
            'parent'                 => '👨‍💼 Super Admin Group',
            'system_administrator'   => '👨‍💻 System Administrator'
        ],
        'developer_group'   => [
            'parent'                 => '👨‍💻 Developer Group',
            'programmer'             => '💻 Programmer'
        ],
        'inspector_group'   => [
            'parent'                 => '🕵️ Inspector Group',
            'inspector'              => '🔍 Inspector'
        ]
    ]
];
