<?php

namespace Framework\Exceptions;

use Exception;
use Throwable;

class RouteNotFoundException extends Exception
{
    private $route;

    public function __construct(string $route, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->route = $route;
    }

    public function getRouteFound()
    {
        return "Route found: " . $this->route;
    }
}
