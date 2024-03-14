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

            [
                'route' => 'language.index',
                'icon' => 'icofont-earth',
                'title' => 'QL Ngôn ngữ',
                'activeCondition' => ['language.*']
            ],
            [
                'route' => 'user.index',
                'icon' => 'icofont-newspaper',
                'title' => 'QL Bài viết',
                'activeCondition' => ['post.*']
            ],
            [
                'route' => 'post.catalogue.index',
                'icon' => 'icofont-newsvine',
                'title' => 'QL Nhóm bài viết',
                'activeCondition' => ['post.catalogue.*']
            ],
        ]

    ],
];
