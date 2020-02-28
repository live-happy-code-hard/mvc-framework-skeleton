<?php
$baseDir = dirname(__DIR__);
require $baseDir . '/vendor/autoload.php';

use Application\Controller\UserController;
use Framework\Application;
use Framework\Dispatcher\Dispatcher;
use Framework\Exceptions\RouteNotFoundException;
use Framework\Http\Request;
use Framework\Http\Stream;
use Framework\Http\Uri;
use Framework\Renderer\Renderer;
use Framework\Routing\Router;

ini_set("display_errors", 1);

$container = require $baseDir.'/config/services.php';

// create the application and handle the request
$application = Application::create($container);
$request = Request::createFromGlobals();
$response = $application->handle($request);
$response->send();

