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
        return $this->method;
    }

    public function getControllerName(): string
    {
        return $this->controllerName;
    }

    public function getActionName(): string
    {
        return $this->actionName;
    }

    public function getRequestAttributes(): array
    {
        return $this->requestAttributes;
    }

    public function __toString()
    {
        return $this->getMethod() . "<br>" . $this->getControllerName() . "<br>" . $this->getActionName() . "<br>" . implode(" ", $this->getRequestAttributes()) . "<br>";
    }
}
