<?php

return array(
    "User_GET" => [
        "method" => "GET",
        "path" => '/user',
        "actionName" => "read",
        "controllerName" => "Framework\Controller\UserController"
    ],

    "User_Id_GET" => [
        "method" => "GET",
        "path" => '/user/(?<id>\d+)',
        "actionName" => "read",
        "controllerName" => "Framework\Controller\UserController"
    ],

    "User_Id_Role_GET" => [
        "method" => "GET",
        "path" => '/user/(?<id>\d+)/role/(?<role>ADMIN|GUEST)',
        "actionName" => "read",
        "controllerName" => "Framework\Controller\UserController"
    ],

);
