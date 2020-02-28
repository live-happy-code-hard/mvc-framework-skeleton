<?php

namespace Framework;

use Exception;
use Framework\Contracts\DispatcherInterface;
use Framework\Contracts\RouterInterface;
use Framework\Exceptions\RouteDoesNotExistException;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Routing\RouteMatch;
use Framework\Contracts\ContainerInterface;

class Application
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public static function create(ContainerInterface $container): self
    {
        $aplication = new self($container);
//        $container->set(self::class, $aplication);

        return $aplication;
    }

    public function handle(Request $request): Response
    {
        try {
            $routeMatch = $this->getRouter()->route($request);
        } catch (RouteDoesNotExistException $exception) {
            $routeMatch = new RouteMatch
            (
                $exception->getMethod(),
                $exception->getControllerName(),
                $exception->getActionName(),
                []
            );
        }
        $response = $this->getDispatcher()->dispatch($routeMatch, $request);

        return $response;
    }

    private function getRouter(): RouterInterface
    {
        return $this->container->get(RouterInterface::class);
    }

    private function getDispatcher(): DispatcherInterface
    {
        return $this->container->get(DispatcherInterface::class);
    }
}
