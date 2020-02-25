<?php
$baseDir = dirname(__DIR__);
require $baseDir.'/vendor/autoload.php';
use Framework\Application;

use Framework\Http\Request;
use Framework\Routing\Router;


$uri = "http://mvc-framework.com/user/122/setRole/ADMIN";
$uri = parse_url($uri);
$re = '/^\/user\/(?<id>\d+)\/setRole\/(?<role>ADMIN|GUEST)$/';
//print_r($uri);
//echo  $uri["path"];
//preg_match($re, $uri["path"], $matches);



$config = require('/var/www/mvc-framework-skeleton/config/routing.php');
$request = new Request();
$router = new Router($config);

$match = $router->route($request);
print_r($match);




//
//// obtain the base directory for the web application a.k.a. document root
//$baseDir = dirname(__DIR__);
//
//// setup auto-loading
//require $baseDir.'/vendor/autoload.php';
//
//// obtain the DI container
//$container = require $baseDir.'/config/services.php';
//
//// create the application and handle the request
//$application = Application::create($container);
//$request = Request::createFromGlobals();
//$response = $application->handle($request);
//$response->send();
//

