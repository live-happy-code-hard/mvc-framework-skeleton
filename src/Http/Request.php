<?php

namespace Framework\Http;

use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

class Request extends Message
{
    private $method;
    private $URI;
    private $requestTarget;
    private $parameter;
    private $cookie;

    public function __construct
    (
        string $protocolVersion,
        array $headers,
        StreamInterface $body,
        string $method,
        UriInterface $uri,
        array $cookie,
        string $requestTarget
    )
    {
        $this->method = $method;
        $this->URI = $uri;
        $this->cookie= $cookie;
        $this->requestTarget = $requestTarget;

        parent::__construct($protocolVersion, $headers, $body);
    }

    public static function createFromGlobals(): self
    {
        // look in $_GET, $_POST, $_SERVER, $_FILES, $_COOKIES and extract data into this objects properties for
        // easy access
        $protocolVersion = $_SERVER['SERVER_PROTOCOL'];
        $protocolVersion = explode("/", $protocolVersion);
        $protocolVersion = $protocolVersion[1];

        foreach ($_SERVER as $item => $value){
            if( explode("_", $item)[0] == "HTTP")
                $headers[$item] =  $value;
        }
        $bodyStream = fopen("php://input", "r+");
        $stream = new Stream($bodyStream);

        $uri = URI::createUriFromGlobals();

        $method = $_SERVER['REQUEST_METHOD'];

        $cookie = $_COOKIE;

        $requestTarget = $_SERVER['HTTP_HOST'];

        return new self($protocolVersion, $headers, $stream, $method, $uri, $cookie, $requestTarget);
    }

    public function getParameter(string $name)
    {

        return $this->parameter[$name];
    }

    public function getCookie(string $name)
    {
        if (isset($this->cookie[$name])){
            return $this->cookie[$name];
        }
        return [];
    }

    public function moveUploadedFile(string $file, string $path)
    {

        return move_uploaded_file($file, $path);
    }

    public function getPath(){

        return $this->URI->getPath();
    }

    /**
     * @inheritDoc
     */
    public function getRequestTarget()
    {
        return $this->requestTarget;
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
    public function getMethod()
    {

        return $this->method;
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

        return $this->URI;
    }

    /**
     * @inheritDoc
     */
    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        $request = clone $this;
        $request->URI = $uri;
//        if (isset($request->getHeader($preserveHost)))

        return $request;
    }
}
