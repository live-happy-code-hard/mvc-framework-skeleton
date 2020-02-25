<?php

namespace Framework\Routing;

class RouteMatch
{
    private $method;
    private $controllerName;
    private $actionName;
    private $requestAttribute;

    public function __construct(
        string $method,
        string $controllerName,
        string $actionName,
        array $requestAttribute
    )
    {
        $this->method = $method;
        $this->controllerName = $controllerName;
        $this->actionName = $actionName;
        $this->requestAttribute = $requestAttribute;
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

        return $this->requestAttribute;
    }
}
