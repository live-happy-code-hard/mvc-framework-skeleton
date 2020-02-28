<?php

use Framework\Contracts\DispatcherInterface;
use Framework\Contracts\RendererInterface;
use Framework\Contracts\RouterInterface;
use Framework\Controller\UserController;
use Framework\DependencyInjection\SymfonyContainer;
use Framework\Dispatcher\Dispatcher;
use Framework\Renderer\Renderer;
use Framework\Routing\Router;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

$config = require ("routes.php");

$container = new ContainerBuilder();


$container->setParameter('configRoutes', $config[Router::CONFIG_ROUTER][Router::CONFIG_ROUTES]);
$container->setParameter('controllerNameSpace',  $config[Router::CONFIG_CONTROLLER][Router::CONFIG_CONTROLLER_NAMESPACE]);
$container->setParameter('controllerSuffix',  $config[Router::CONFIG_CONTROLLER][Router::CONFIG_CONTROLLER_SUFIX]);
$container->setParameter('baseViewsPath',  $config[Router::CONFIG_BASE_DIR_VIEWS]);

$container->register(RouterInterface::class, Router::class)
    ->addArgument('%configRoutes%');

$container->register(UserController::class, UserController::class)
    ->addArgument(new Reference(RendererInterface::class));

$container->register(DispatcherInterface::class, Dispatcher::class)
    ->addArgument('%controllerNameSpace%')
    ->addArgument('%controllerSuffix%')
    ->addMethodCall('addController', [new Reference(UserController::class)]);

$container->register(RendererInterface::class, Renderer::class)
    ->addArgument('%baseViewsPath%');






//var_dump($container->get(RouterInterface::class));
//var_dump($container->get(DispatcherInterface::class));
//var_dump($container->get(RendererInterface::class));
//var_dump($container->get(UserController::class));
return new SymfonyContainer($container);