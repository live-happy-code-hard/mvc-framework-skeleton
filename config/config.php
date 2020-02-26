<?php

use Framework\Routing\Router;

return array(
    'dispatcher' => [
        'controllers_namespace' => 'Application\Controller',
        'controller_class_suffix' => 'Controller'
    ],
    'router' => [
        'routes' => [
            'list_users' => [
                Router::CONFIG_KEY_METHOD => 'GET',
                Router::CONFIG_KEY_PATH => '/user',
                Router::CONFIG_KEY_ACTION => 'read',
                Router::CONFIG_KEY_CONTROLLER => 'user',
                Router::CONFIG_KEY_ATTRIBUTES => []
            ],

            'view_user' => [
                Router::CONFIG_KEY_METHOD => 'GET',
                Router::CONFIG_KEY_PATH => '/user/{id}',
                Router::CONFIG_KEY_ACTION => 'read',
                Router::CONFIG_KEY_CONTROLLER => 'user',
                Router::CONFIG_KEY_ATTRIBUTES => [
                    'id' => '\d+'
                ]
            ],

            'viw_user_type' => [
                Router::CONFIG_KEY_METHOD => 'GET',
                Router::CONFIG_KEY_PATH => '/user/{id}/role/{role}',
                Router::CONFIG_KEY_ACTION => 'read',
                Router::CONFIG_KEY_CONTROLLER => 'user',
                Router::CONFIG_KEY_ATTRIBUTES => [
                    'id' => '\d+',
                    'role' => 'ADMIN|GUEST'
                ]

            ],
        ]
    ]


);
