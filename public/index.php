<?php
//$baseDir = dirname(__DIR__);
//require $baseDir.'/vendor/autoload.php';
//use Framework\Application;
//
//use Framework\Http\Request;
//use Framework\Renderer\Renderer;
//use Framework\Routing\Router;
//use Framework\Dispatcher\Dispatcher;
//
//ini_set("display_errors",1);
//
//$container = require $baseDir.'/config/services.php';
//$config = require($baseDir."/config/routes.php");

//print_r($config[Router::CONFIG_ROUTER][Router::CONFIG_ROUTES]);
//$request = Request::createFromGlobals();
//$router = new Router($config[Router::CONFIG_ROUTER][Router::CONFIG_ROUTES]);

//$match = $router->route($request); //class RouteMatch
//
//$renderer = new Renderer($baseDir."/Views/");
//
//$dispatch = new Dispatcher
//(
//    $config[Router::CONFIG_CONTROLLER][Router::CONFIG_CONTROLLER_NAMESPACE],
//    $config[Router::CONFIG_CONTROLLER][Router::CONFIG_CONTROLLER_SUFIX]
//);
//
//$controller = new \Framework\Controller\UserController($renderer);
//$dispatch->addController($controller);
//$response = $dispatch->dispatch($match,$request);
//$response->send();

//print_r($match);





// obtain the base directory for the web application a.k.a. document root
use Framework\Application;
use Framework\Http\Request;

$baseDir = dirname(__DIR__);
//
// setup auto-loading
require $baseDir.'/vendor/autoload.php';

// obtain the DI container
$container = require $baseDir.'/config/services.php';

// create the application and handle the request
$application = Application::create($container);
$request = Request::createFromGlobals();
$response = $application->handle($request);
$response->send();


