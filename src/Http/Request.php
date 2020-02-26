<?php

namespace Framework\Http;

use Framework\Routing\Router;
use Psr\Http\Message\UriInterface;

class Request extends Message

{
    public static function createFromGlobals(): self
    {
        // TODO:
        // look in $_GET, $_POST, $_SERVER, $_FILES, $_COOKIES and extract data into this objects properties for
        // easy access



        return new self();
    }

    public function getParameter(string $name)
    {
        //TODO
    }

    public function getCookie(string $name)
    {
        //TODO
    }

    public function moveUploadedFile(string $path)
    {
        //TODO
    }

    public function getPath(){
        $url = parse_url($this->getUri());
        return $url[Router::CONFIG_ROUTES_KEY_PATH];
    }

    // TODO: implement methods declared by RequestInterface
    /**
     * @inheritDoc
     */
    public function getRequestTarget()
    {
        // TODO: Implement getRequestTarget() method.
    }

    /**
     * @inheritDoc
     */
    public function withRequestTarget($requestTarget)
    {
        // TODO: Implement withRequestTarget() method.
    }

    /**
     * @inheritDoc
     */
    public function getMethod()
    {
        // TODO: Implement getMethod() method.

        return "GET";
    }

    /**
     * @inheritDoc
     */
    public function withMethod($method)
    {
        // TODO: Implement withMethod() method.
    }

    /**
     * @inheritDoc
     */
    public function getUri()
    {
        // TODO: Implement getUri() method.
//        $uri = $_SERVER['REQUEST_URI'];
        return "http://mvc.com/user/1/setRole/ADMIN/asd";
    }

    /**
     * @inheritDoc
     */
    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        // TODO: Implement withUri() method.
    }
}
