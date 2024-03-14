<?php
return [
    'module' => [
        'sidebar' => [
            [
                'id' => 'dashboard',
                'route' => 'dashboard.index',
                'icon' => 'icofont-home',
                'title' => 'Bảng điều khiển',
                'activeCondition' => ['dashboard.*'],
            ],
            [
                'id' => 'user',
                'route' => '',
                'icon' => 'icofont-users',
                'title' => 'QL Thành viên',
                'activeCondition' => ['user.*'],
                'subMenu' => [
                    [
                        'title' => 'QL Thành viên',
                        'route' => 'user.index',
                        'activeCondition' => ['user.index', 'user.create', 'user.edit'],
                    ],
                    [
                        'title' => 'QL Nhóm thành viên',
                        'route' => 'user.catalogue.index',
                        'activeCondition' => ['user.catalogue.*']
                    ],
                ]
            ],

            [
                'id' => 'post',
                'route' => '',
                'icon' => 'icofont-newspaper',
                'title' => 'QL Bài viết',
                'activeCondition' => ['post.*'],
                'subMenu' => [
                    [
                        'title' => 'QL Bài viết',
                        'route' => 'user.index',
                        'activeCondition' => ['user.index', 'user.create', 'user.edit'],
                    ],
                    [
                        'title' => 'QL Nhóm bài viết',
                        'route' => 'post.catalogue.index',
                        'activeCondition' => ['post.catalogue.*']
                    ],
                ]
            ],

            [
                'id' => 'generalConfig',
                'route' => '',
                'icon' => 'icofont-ui-settings',
                'title' => 'Cấu hình chung',
                'activeCondition' => ['language.*'],
                'subMenu' => [
                    [
                        'title' => 'QL Ngôn ngữ',
                        'route' => 'language.index',
                        'activeCondition' => ['language.*']
                    ],
                ]
            ],

        ]

    ],
];
