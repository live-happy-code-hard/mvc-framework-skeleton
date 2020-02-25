<?php

namespace Framework\Routing;

use Framework\Contracts\RouterInterface;
use Framework\Http\Request;

class Router implements RouterInterface
{
    private $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function route(Request $request): RouteMatch
    {
        foreach ($this->config as $key => $array){
            if(preg_match($this->createPath($array["path"]),$request->getPath()) && $array["method"] === $request->getMethod()){
                return new RouteMatch(
                    $request->getMethod(),
                    $array["controllerName"],
                    $array["actionName"],
                    $this->getRequestAttributes($this->createPath($array["path"]),$request->getPath())
                );
            }
        }
        return null;
    }

    private function getRequestAttributes(string $path,string $request): array
    {
        preg_match($path,$request,$rez);

        return array_filter($rez, "is_string", ARRAY_FILTER_USE_KEY);
    }

    public function createPath(string $path)
    {
        return "/^" . str_replace("/","\/",$path) . "$/";
    }

}