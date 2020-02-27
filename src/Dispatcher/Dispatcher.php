<?php

namespace Framework\Dispatcher;
use Framework\Contracts\DispatcherInterface;
use Framework\Controller\AbstractController;
use Framework\Http\Request;
use Framework\Routing\RouteMatch;
use Framework\Http\Response;

class Dispatcher implements DispatcherInterface
{

    private $controllers;

    /**
     * @inheritDoc
     */
    public function dispatch(RouteMatch $routeMatch, Request $request): Response
    {
        //STEP 1: FQCN
        $fullControllerName = $routeMatch->getControllerName();
        //STEP 2: Find the controller
        //$this->addController(new $fullControllerName);

        //$controllerName = UserController(new Renderer());
        $controller = $this->getController($fullControllerName);
        $action = $routeMatch->getActionName();
        $response = $controller->$action($request, $routeMatch->getRequestAttributes());

        return $response;
    }

    public function addController(AbstractController $controller){
        $this->controllers[] = $controller;
    }


    private function getController(string $controllerName)
    {
        foreach($this->controllers as $controller) {
            if($controllerName === get_class($controller)) {
                return $controller;
            }
        }
        //throw new ControllerNotFoundException();
    }

}
