<?php
return [
    'module' => [
        [
            'id' => 'dashboard',
            'route' => 'dashboard.index',
            'icon' => 'icofont-home',
            'title' => '控制台', // Dashboard
            'activeCondition' => ['dashboard.*'],
        ],
        [
            'id' => 'user',
            'route' => '',
            'icon' => 'icofont-users',
            'title' => '客户', // Customers
            'activeCondition' => ['user.*'],
            'subMenu' => [
                [
                    'title' => '客户', // Customers
                    'route' => 'user.index',
                    'activeCondition' => ['user.index', 'user.create', 'user.edit'],
                ],
                [
                    'title' => '客户分组', // Customer Group
                    'route' => 'user.catalogue.index',
                    'activeCondition' => ['user.catalogue.*']
                ],
            ]
        ],

        [
            'id' => 'post',
            'route' => '',
            'icon' => 'icofont-newspaper',
            'title' => '帖子', // Posts
            'activeCondition' => ['post.*'],
            'subMenu' => [
                [
                    'title' => '帖子', // Posts
                    'route' => 'post.index',
                    'activeCondition' => ['post.index', 'post.create', 'post.edit'],
                ],
                [
                    'title' => '帖子分组', // Post Group
                    'route' => 'post.catalogue.index',
                    'activeCondition' => ['post.catalogue.*']
                ],
            ]
        ],

        [
            'id' => 'generalConfig',
            'route' => '',
            'icon' => 'icofont-ui-settings',
            'title' => '配置', // Configuration
            'activeCondition' => ['language.*'],
            'subMenu' => [
                [
                    'title' => '语言设置', // Language Settings
                    'route' => 'language.index',
                    'activeCondition' => ['language.*']
                ],
            ]
        ],

    ]


];
