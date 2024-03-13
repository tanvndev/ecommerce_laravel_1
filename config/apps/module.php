<?php
return [
    'module' => [
        'user' => [
            [
                'route' => 'dashboard.index',
                'icon' => 'icofont-home',
                'title' => 'Bảng điều khiển',
                'activeCondition' => ['dashboard.*']
            ],
            [
                'route' => 'user.index',
                'icon' => 'icofont-user',
                'title' => 'QL Thành viên',
                'activeCondition' => ['user.index', 'user.create', 'user.edit']
            ],
            [
                'route' => 'user.catalogue.index',
                'icon' => 'icofont-users',
                'title' => 'QL Nhóm thành viên',
                'activeCondition' => ['user.catalogue.*']
            ],
        ]

    ],
];
