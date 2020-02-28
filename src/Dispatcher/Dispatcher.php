<?php

namespace Framework\Dispatcher;

use Framework\Contracts\DispatcherInterface;
use Framework\Controller\AbstractController;
use Framework\Exception\ControllerNotFoundException;
use Framework\Http\Request;
use Framework\Routing\RouteMatch;
use Framework\Http\Response;

class Dispatcher implements DispatcherInterface
{
    /**
     * @var array
     */
    private $controllers;
    private $controllerNamespace;
    private $controllerSuffix;

    /**
     * Dispatcher constructor.
     * @param $controllerNamespace
     * @param $controllerSuffix
     */
    public function __construct($controllerNamespace, $controllerSuffix)
    {
        $this->controllerNamespace = $controllerNamespace;
        $this->controllerSuffix = $controllerSuffix;
    }

    /**
     * @inheritDoc
     * @throws ControllerNotFoundException
     */
    public function dispatch(RouteMatch $routeMatch, Request $request): Response
    {
        $fullControllerName = $this->getFullControllerName($routeMatch->getControllerName());
        $controller = $this->getController($fullControllerName);
        $action = $routeMatch->getActionName();

        return $controller->$action($request, $routeMatch->getRequestAttributes());
    }

    /**
     * @param string $controllerName
     * @return string
     */
    private function getFullControllerName(string $controllerName)
    {
        return $this->controllerNamespace . '\\' . ucfirst($controllerName) . $this->controllerSuffix;
    }

    /**
     * @param AbstractController $controller
     */
    public function addController(AbstractController $controller)
    {
        $this->controllers[] = $controller;
    }

    /**
     * @param string $controllerName
     * @return mixed
     * @throws ControllerNotFoundException
     */
    private function getController(string $controllerName)
    {
        foreach ($this->controllers as $controller) {
            if ($controllerName === get_class($controller)) {
                return $controller;
            }
        }
        throw new ControllerNotFoundException("Controller not found!");
    }
}
