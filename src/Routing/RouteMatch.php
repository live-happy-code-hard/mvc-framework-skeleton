<?php

namespace Framework\Routing;

class RouteMatch
{
    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $controllerName;

    /**
     * @var string
     */
    private $actionName;

    /**
     * @var array
     */
    private $requestAttributes;

    /**
     * RouteMatch constructor.
     * @param $method
     * @param $controllerName
     * @param $actionName
     * @param $requestAttributes
     */
    public function __construct($method, $controllerName, $actionName, $requestAttributes)
    {
        $this->method = $method;
        $this->controllerName = $controllerName;
        $this->actionName = $actionName;
        $this->requestAttributes = $requestAttributes;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getControllerName(): string
    {
        return $this->controllerName;
    }

    /**
     * @return string
     */
    public function getActionName(): string
    {
        return $this->actionName;
    }

    /**
     * @return array
     */
    public function getRequestAttributes(): array
    {
        return $this->requestAttributes;
    }
}
