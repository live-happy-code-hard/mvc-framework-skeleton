<?php

namespace Framework\Http;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

class Request extends Message implements RequestInterface
{
    private $method;
    private $uri;
    private $requestTarget;

    public function __construct
    (
        string $protocolVersion,
        string $httpMethod,
        UriInterface $uri,
        StreamInterface $body
    )
    {
        parent::__construct($protocolVersion, $body);
        $this->method = $httpMethod;
        $this->uri = $uri;
    }
    public static function createFromGlobals(): self
    {
        $protocolVersion = $_SERVER['SERVER_PROTOCOL'];
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = Uri::createFromGlobals();
        $body = new Stream(fopen('php://input','r'));

        $request = new self($protocolVersion,$httpMethod,$uri,$body);
        foreach($_SERVER as $variableName => $variableValue){
            if(strpos($variableName,'HTTP_') !== 0) {
                continue;
            }
            $request->addRawHeader($variableName,$variableValue);
        }

        return $request;
    }

    public function getPath()
    {
        return $this->uri->getPath();
    }

    public function getParameter(string $name)
    {
        return $_GET[$name];
    }

    public function getCookie(string $name)
    {
        return $_COOKIE[$name];
    }

    public function moveUploadedFile(string $path)
    {
        //TODO
    }

    /**
     * @inheritDoc
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @inheritDoc
     */
    public function getRequestTarget()
    {
        if ($this->requestTarget) {
            return $this->requestTarget;
        }
        if ($this->uri) {
            return $this->uri;
        }

        return "/";
    }

    /**
     * @inheritDoc
     */
    public function withRequestTarget($requestTarget)
    {
        $request = clone $this;
        $request->requestTarget = $requestTarget;

        return $request;
    }

    /**
     * @inheritDoc
     */
    public function withMethod($method)
    {
        $request = clone $this;
        $request->method = $method;

        return $request;
    }

    /**
     * @inheritDoc
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @inheritDoc
     */
    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        $request = clone $this;
        $request->uri = $uri;

        return $request;
    }
}
