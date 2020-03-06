<?php

namespace Framework\Routing;

use Framework\Contracts\RouterInterface;
use Framework\Exceptions\RouteNotFoundException;
use Framework\Http\Request;

class Router implements RouterInterface
{
    const CONFIG_KEY_PATH = 'path';
    const CONFIG_KEY_METHOD = 'method';
    const CONFIG_KEY_ACTION = 'actionName';
    const CONFIG_KEY_CONTROLLER = 'controllerName';
    const CONFIG_KEY_ATTRIBUTES = 'attributes';
    private $config;

    /**
     * Router constructor.
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * @param Request $request
     * @return RouteMatch
     * @throws RouteNotFoundException
     */
    public function route(Request $request): RouteMatch
    {
        foreach ($this->config['router']['routes'] as $routeName => $route) {
            if ($route[self::CONFIG_KEY_METHOD] !== $request->getMethod()) {
                continue;
            }
            if (preg_match($this->createRegex($route), $request->getPath())) {
                return new RouteMatch(
                    $request->getMethod(),
                    $route[self::CONFIG_KEY_CONTROLLER],
                    $route[self::CONFIG_KEY_ACTION],
                    $this->getRequestAttributes($this->createRegex($route), $request->getPath())
                );
            }
        }
        throw new RouteNotFoundException($request->getPath());
    }

    /**
     * @param array $route
     * @return string
     */
    private function createRegex(array $route)
    {
        $path = $route[self::CONFIG_KEY_PATH];
        if (self::CONFIG_KEY_ATTRIBUTES) {
            foreach ($route[self::CONFIG_KEY_ATTRIBUTES] as $valueName => $regex) {
                $path = str_replace('{' . $valueName . '}', '(?<' . $valueName . '>' . $regex . ')', $path);
            }
        }
        return '/^' . str_replace('/', '\/', $path) . '$/';
    }

    /**
     * @param string $path
     * @param string $request
     * @return array
     */
    private function getRequestAttributes(string $path, string $request): array
    {
        preg_match($path, $request, $result);

        return array_filter($result, 'is_string', ARRAY_FILTER_USE_KEY);
    }
}
