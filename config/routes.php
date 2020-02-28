<?php

use Framework\Routing\Router;


return array(
    Router::CONFIG_BASE_DIR_VIEWS => "/var/www/mvc-framework-skeleton/Views",
    Router::CONFIG_CONTROLLER => [
        Router::CONFIG_CONTROLLER_NAMESPACE => "Framework\Controller",
        Router::CONFIG_CONTROLLER_SUFIX => "Controller"
    ],
    Router::CONFIG_ROUTER => [
        Router::CONFIG_ROUTES => [
            "notFound" => [
                Router::CONFIG_ROUTES_KEY_METHOD => "GET",
                Router::CONFIG_ROUTES_KEY_CONTROLLERNAME => "exception",
                Router::CONFIG_ROUTES_KEY_ACTIONNNAME => "routeDoesNotExist",
                Router::CONFIG_ROUTES_KEY_PATH => "/error",
                Router::CONFIG_ROUTES_KEY_REQESTATTRIBUTES => []
            ],
            "getUsers" => [
                Router::CONFIG_ROUTES_KEY_METHOD => "GET",
                Router::CONFIG_ROUTES_KEY_CONTROLLERNAME => "user",
                Router::CONFIG_ROUTES_KEY_ACTIONNNAME => "getUsers",
                Router::CONFIG_ROUTES_KEY_PATH => "/user",
                Router::CONFIG_ROUTES_KEY_REQESTATTRIBUTES => []
            ],

            "getUser" => [
                Router::CONFIG_ROUTES_KEY_METHOD => "GET",
                Router::CONFIG_ROUTES_KEY_CONTROLLERNAME => "user",
                Router::CONFIG_ROUTES_KEY_ACTIONNNAME => "getUser",
                Router::CONFIG_ROUTES_KEY_PATH => "/user/{id}",
                Router::CONFIG_ROUTES_KEY_REQESTATTRIBUTES => [
                    "id" => "\d+"
                ]
            ],

            "deleteUser" => [
                Router::CONFIG_ROUTES_KEY_METHOD => "DELETE",
                Router::CONFIG_ROUTES_KEY_CONTROLLERNAME => "user",
                Router::CONFIG_ROUTES_KEY_ACTIONNNAME => "deleteUser",
                Router::CONFIG_ROUTES_KEY_PATH => "/user/{id}",
                Router::CONFIG_ROUTES_KEY_REQESTATTRIBUTES => [
                    "id" => "\d+"
                ]
            ],

            "setRoleUser" => [
                Router::CONFIG_ROUTES_KEY_METHOD => "POST",
                Router::CONFIG_ROUTES_KEY_CONTROLLERNAME => "user",
                Router::CONFIG_ROUTES_KEY_ACTIONNNAME => "postUser",
                Router::CONFIG_ROUTES_KEY_PATH => "/user/{id}/setRole/{role}",
                Router::CONFIG_ROUTES_KEY_REQESTATTRIBUTES => [
                    "id" => "\d+",
                    "role" => "ADMIN|GUEST",
                    "p" => "\d+"

                ]
            ]
        ]
    ]
);