<?php
declare(strict_types=1);

namespace Framework\DependencyInjection;

use Framework\Contracts\ContainerInterface;

class SymfonyContainer implements ContainerInterface
{
    /**
     * @var Symfony\Component\DependencyInjection\ContainerInterface
     */
    private $container;

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(\Symfony\Component\DependencyInjection\ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function set(string $id, ?object $service)
    {
        return $this->container->set( $id, $service);
    }

    public function get($id)
    {

        return $this->container->get($id);
    }

    public function has($id)
    {
        return $this->container->has($id);
    }
}
