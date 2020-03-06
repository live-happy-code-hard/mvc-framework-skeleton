<?php


use Framework\Routing\Router;

class UrlHelper
{
    private $config;

    /**
     * UrlHelper constructor.
     * @param $config array
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    public function getUrl(string $id): string
    {
        return $this->config[$id][Router::CONFIG_KEY_PATH];
    }
}
