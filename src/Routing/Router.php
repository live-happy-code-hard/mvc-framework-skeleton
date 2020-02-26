<?php

namespace Framework\Routing;

use Framework\Contracts\RouterInterface;
use Framework\Http\Request;
use RouteNotFoundException;

class Router implements RouterInterface
{
    const CONFIG_KEY_PATH = 'path';
    const CONFIG_KEY_METHOD = 'method';
    const CONFIG_KEY_ACTION = 'actionName';
    const CONFIG_KEY_CONTROLLER = 'controllerName';
    const CONFIG_KEY_ATTRIBUTES = 'attributes';
    private $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function route(Request $request): RouteMatch
    {
        foreach ($this->config['router']['routes'] as $routeName => $route) {
            if ($route[self::CONFIG_KEY_METHOD] === $request->getMethod() &&
                preg_match($this->createRegex($route), $request->getPath())) {
                return new RouteMatch(
                    $request->getMethod(),
                    $this->getFullControllerName($route[self::CONFIG_KEY_CONTROLLER]),
                    $route[self::CONFIG_KEY_ACTION],
                    $this->getRequestAttributes($this->createRegex($route), $request->getPath())
                );
            }
        }

        throw new RouteNotFoundException();
    }

    private function createRegex(array $route)
    {
        $path = $route[self::CONFIG_KEY_PATH];
        foreach ($route[self::CONFIG_KEY_ATTRIBUTES] as $valueName => $regex) {
            $path = str_replace('{' . $valueName . '}', '(?<' . $valueName . '>' . $regex . ')', $path);
        }

        return $this->createPath($path);
    }

    private function getFullControllerName(string $controllername)
    {
        $namespace = $this->config['dispatcher']['controllers_namespace'] . '\\';
        $classSuffix = $this->config['dispatcher']['controller_class_suffix'];

        return $namespace . ucfirst($controllername) . $classSuffix;
    }

    private function getRequestAttributes(string $path, string $request): array
    {
        preg_match($path, $request, $result);

        return array_filter($result, 'is_string', ARRAY_FILTER_USE_KEY);
    }

    private function createPath(string $path)
    {
        return '/^' . str_replace('/', '\/', $path) . '$/';
    }
}
