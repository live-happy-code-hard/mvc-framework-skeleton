<?php

namespace Framework;

use Exception;
use Framework\Contracts\ContainerInterface;
use Framework\Contracts\DispatcherInterface;
use Framework\Contracts\RouterInterface;
use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Routing\RouteMatch;

class Application
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public static function create(ContainerInterface $container): self
    {
        $app = new self($container);
        $container->set(Application::class, $app);

        return new self($container);
    }

    public function handle(Request $request): Response
    {
        $routeMatch = $this->getRouter()->route($request);
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
