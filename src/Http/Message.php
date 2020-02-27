<?php

declare(strict_types=1);

namespace Framework\Http;

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamInterface;


class Message implements MessageInterface
{
    /**
     * @var string
     */
    private $protocolVersion = '';

    /**
     * @var array
     */
    protected $headers;

    /**
     * @var Stream
     */
    private $body;

    /**
     * Message constructor.
     * @param $protocolVersion
     * @param $headers
     * @param $body
     */
    public function __construct(
        $protocolVersion,
        $body)
    {
        $this->protocolVersion = $protocolVersion;
        $this->headers = [];
        $this->body = $body;
    }

    /**
     * @inheritDoc
     */
    public function getProtocolVersion()
    {
        return $this->protocolVersion;
    }

    /**
     * @inheritDoc
     */
    public function withProtocolVersion($version)
    {
        $request = clone $this;
        $request->protocolVersion = $version;

        return $request;
    }

    /**
     * @inheritDoc
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @inheritDoc
     */
    public function hasHeader($name)
    {
        return array_key_exists($name,$this->headers);
    }

    /**
     * @inheritDoc
     */
    public function getHeader($name)
    {
        return preg_split('/,/',$this->headers[$name]);
    }

    /**
     * @inheritDoc
     */
    public function getHeaderLine($name)
    {
        return $this->headers[$name];
    }

    /**
     * @inheritDoc
     */
    public function withHeader($name, $value)
    {
        $request = clone $this;
        $request->headers[$name] = (array) $value;

        return $request;
    }

    /**
     * @inheritDoc
     */
    public function withAddedHeader($name, $value)
    {
        $request = clone $this;
        $request->headers = array_merge($this->headers[$name],$value);

        return $request;
    }

    /**
     * @inheritDoc
     */
    public function withoutHeader($name)
    {
        $request = clone $this;
        unset($request->headers[$name]);

        return $request;
    }

    public function addRawHeader($name, $value)
    {
        $name = ucwords(strtolower(strtr(substr($name, 5), '_', '-')), '-');
        $this->headers[$name] = explode(',', $value);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @inheritDoc
     */
    public function withBody(StreamInterface $body)
    {
        $request = clone $this;
        $request->body = $body;

        return $request;
    }
}
