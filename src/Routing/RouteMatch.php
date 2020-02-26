<?php

namespace Framework\Routing;

class RouteMatch
{
    private $method;
    private $controllerName;
    private $actionName;
    private $requestAttributes;

    public function __construct($method, $controllerName, $actionName, $requestAttributes)
    {
        $this->method = $method;
        $this->controllerName = $controllerName;
        $this->actionName = $actionName;
        $this->requestAttributes = $requestAttributes;
    }

    public function getMethod(): string
    {
        //TODO: return GET, POST, PUT, DELETE ...
        return $this->method;
    }

    public function getControllerName(): string
    {
        //TODO: return the controller name
        return $this->controllerName;
    }

    public function getActionName(): string
    {
        //TODO: return the controller action
        return $this->actionName;
    }

    public function getRequestAttributes(): array
    {
        //TODO: return attributes extracted from PATH_INFO
        return $this->requestAttributes;
    }

    public function __toString()
    {
        return $this->getMethod() . "<br>" . $this->getControllerName() . "<br>" . $this->getActionName() . "<br>" . implode(" ", $this->getRequestAttributes()) . "<br>";
    }
}
