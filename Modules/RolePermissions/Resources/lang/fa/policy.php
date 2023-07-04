<?php

return [
    // List Of Permissions
    'permission' => [
        'role' => [
            'parent'                 => '👥 مجوزهای دسترسی به نقش کاربری',
            'index'                  => '📜 نمایش نقش های کاربری',
            'store'                  => '🆕 ایجاد نقش کاربری',
            'update'                 => '✏️ .ویرایش نقش کاربری',
            'delete'                 => '🗑️حذف نقش کاربری',
        ],
        'permission' => [
            'parent'                 => '🔒 مجوز دسترسی',
            'index'                  => '📜 مشاهده مجوزها'
        ],
    ],
    // List Of Roles
    'role' => [
        'user_group'       => [
            'parent'                 => '👤 گروه کاربران',
            'regular_user'           => '🙂 کاربر معمولی'
        ],
        'manager_group'    => [
            'parent'                 => '🧑‍💼 گروه مدیر',
            'resource_manager'       => '🤝 مدیر منابع',
            'project_manager'        => '📈 مدیر پروژه',
            'account_manager'        => '💰 مدیر حساب',
            'team_manager'           => '👥 مدیر تیم',
            'communications_manager' => '📞 مدیر ارتباطات',
            'marketing_manager'      => '📣 مدیر بازاریابی'
        ],
        'super_admin_group' => [
            'parent'                 => '👨‍💼 گروه مدیریت کل',
            'system_administrator'   => '👨‍💻 مدیر سیستم'
        ],
        'developer_group'   => [
            'parent'                 => '👨‍💻 گروه توسعه دهندگان',
            'programmer'             => '💻 برنامه نویس'
        ],
        'inspector_group'   => [
            'parent'                 => '🕵️ گروه بازرس',
            'inspector'              => '🔍 بازرس'
        ]
    ]
];
