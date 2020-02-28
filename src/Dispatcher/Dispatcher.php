<?php


namespace Framework\Dispatcher;


use Framework\Contracts\DispatcherInterface;
use Framework\Controller\AbstractController;
use Framework\Exceptions\ControllerDoesNotExist;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Routing\RouteMatch;
use Framework\Routing\Router;

class Dispatcher implements DispatcherInterface
{
    private $controllerNameSpace;
    private $controllerSuffix;
    private $controlllerList;

    /**
     * Dispatcher constructor.
     * @param string $controllerNameSpace
     * @param string $controllerSuffix
     */
    public function __construct(string $controllerNameSpace, string $controllerSuffix)
    {
        $this->controllerNameSpace = $controllerNameSpace;
        $this->controllerSuffix = $controllerSuffix;
        $this->controlllerList = array();
    }

    /**
     * function injection for controllers;
     * @param AbstractController $controller
     */
    public function addController(AbstractController $controller)
    {

        $this->controlllerList[] = $controller;
    }

    /**
     * get the full path of controller and return the controller to make action
     * @param RouteMatch $routeMatch
     * @param Request $request
     * @return Response
     * @throws ControllerDoesNotExist
     */
    public function dispatch(RouteMatch $routeMatch, Request $request): Response
    {
        $fPathController = $this->controllerNameSpace .
            "\\" .
            ucfirst($routeMatch->getControllerName()) .
            $this->controllerSuffix;
        foreach ($this->controlllerList as $item) {
            if (get_class($item) == $fPathController) {
                $controller = $item;

                $actionName = $routeMatch->getActionName();
                $response = $controller->$actionName($request, $routeMatch->getRequestAttributes());

                return $response;
            }
        }


//        throw  RouteDoesNotExistException::forMissingRoute($exception);
    }
}