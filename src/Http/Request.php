<?php

namespace Framework\Http;

use Framework\Exceptions\FileNotFoundException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

class Request extends Message implements RequestInterface
{
    /**
     * @var string
     */
    private $method;

    /**
     * @var UriInterface
     */
    private $uri;

    /**
     * @var
     */
    private $requestTarget;


    private $parameters;

    /**
     * Request constructor.
     * @param string $protocolVersion
     * @param string $httpMethod
     * @param UriInterface $uri
     * @param StreamInterface $body
     * @param array $parameters
     */
    public function __construct
    (
        string $protocolVersion,
        string $httpMethod,
        UriInterface $uri,
        StreamInterface $body,
        array $parameters
    )
    {
        parent::__construct($protocolVersion, $body);
        $this->method = $httpMethod;
        $this->uri = $uri;
        $this->parameters = $parameters;
    }

    /**
     * @return static
     */
    public static function createFromGlobals(): self
    {
        $protocolVersion = $_SERVER['SERVER_PROTOCOL'];
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = Uri::createFromGlobals();
        $body = new Stream(fopen('php://input', 'r'));
        $parameters = array_merge($_GET,$_POST);
        $request = new self($protocolVersion, $httpMethod, $uri, $body, $parameters);
        foreach ($_SERVER as $variableName => $variableValue) {
            if (strpos($variableName, 'HTTP_') !== 0) {
                continue;
            }
            $request->addRawHeader($variableName, $variableValue);
        }

        return $request;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->uri->getPath();
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getParameter(string $name)
    {
        return $this->parameters[$name];
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getCookie(string $name)
    {
        return $_COOKIE[$name];
    }

    /**
     * @param string $fileName
     * @param string $path
     * @throws FileNotFoundException
     */
    public function moveUploadedFile(string $fileName, string $path)
    {
        if (isset($_FILES[$fileName])) {
            throw new FileNotFoundException();
        }
        if ($_FILES[$fileName]['error'] === UPLOAD_ERR_OK) {
            move_uploaded_file($_FILES[$fileName]['tmp_name'], $path);
        }
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
