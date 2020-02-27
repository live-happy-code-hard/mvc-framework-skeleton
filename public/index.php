<?php
$baseDir = dirname(__DIR__);
require $baseDir . '/vendor/autoload.php';

use Application\Controller\UserController;
use Framework\Application;
use Framework\Dispatcher\Dispatcher;
use Framework\Http\Request;
use Framework\Http\Stream;
use Framework\Http\Uri;
use Framework\Renderer\Renderer;
use Framework\Routing\Router;

ini_set("display_errors", 1);

//// obtain the base directory for the web application a.k.a. document root

//
//// setup auto-loading

//
//// obtain the DI container
//$container = require $baseDir.'/config/services.php';
//
//// create the application and handle the request
//$application = Application::create($container);
//$request = Request::createFromGlobals();
//$response = $application->handle($request);
//$response->send();


$config = require '/var/www/mvc-framework-skeleton/config/config.php';
//$router = new Router($config);
//$request = new Request("1.0","",Uri::createFromGlobals(), new Stream(fopen('php://input','r')));
//$match = $router->route($request);

//print $match;
//print_r($match->getRequestAttributes());
//echo '<br><br>';

$request = Request::createFromGlobals();
$router = new Router($config);
$dispatcher = new Dispatcher();
$renderer = new Renderer($config['renderer'][Renderer::CONFIG_KEY_BASE_VIEW_PATH]);
$controller = new UserController($renderer);
$dispatcher->addController($controller);
$response = $dispatcher->dispatch($router->route($request),$request);
$response->send();


//var_dump($request);
//$uri =  Uri::createFromGlobals();
//echo 'URI: ' . $uri;
//echo '<br><br>';
//$stream =  Stream::createFromString("This is my stream!");
//echo $stream->getContents();

