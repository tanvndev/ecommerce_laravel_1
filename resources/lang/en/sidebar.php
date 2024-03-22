<?php
return [
    'module' => [
        [
            'id' => 'dashboard',
            'route' => 'dashboard.index',
            'icon' => 'icofont-home',
            'title' => 'Dashboard',
            'activeCondition' => ['dashboard.*'],
        ],
        [
            'id' => 'user',
            'route' => '',
            'icon' => 'icofont-users',
            'title' => 'Customers',
            'activeCondition' => ['user.*'],
            'subMenu' => [
                [
                    'title' => 'Customers',
                    'route' => 'user.index',
                    'activeCondition' => ['user.index', 'user.create', 'user.edit'],
                ],
                [
                    'title' => 'Customer Group',
                    'route' => 'user.catalogue.index',
                    'activeCondition' => ['user.catalogue.*']
                ],
            ]
        ],

        [
            'id' => 'post',
            'route' => '',
            'icon' => 'icofont-newspaper',
            'title' => 'Posts',
            'activeCondition' => ['post.*'],
            'subMenu' => [
                [
                    'title' => 'Posts',
                    'route' => 'post.index',
                    'activeCondition' => ['post.index', 'post.create', 'post.edit'],
                ],
                [
                    'title' => 'Post Group',
                    'route' => 'post.catalogue.index',
                    'activeCondition' => ['post.catalogue.*']
                ],
            ]
        ],

        [
            'id' => 'generalConfig',
            'route' => '',
            'icon' => 'icofont-ui-settings',
            'title' => 'Configuration',
            'activeCondition' => ['language.*'],
            'subMenu' => [
                [
                    'title' => 'Language ',
                    'route' => 'language.index',
                    'activeCondition' => ['language.*']
                ],
            ]
        ],

    ]


];
