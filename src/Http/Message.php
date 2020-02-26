<?php


namespace Framework\Http;


use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamInterface;

class Message implements MessageInterface
{
    private $protocolVersion;
    private $headers;
    
    public function __construct()
    {
        
    }

    /**
     * @inheritDoc
     */
    public function getProtocolVersion()
    {
        // TODO: Implement getProtocolVersion() method.
        return $this->protocolVersion;
    }

    /**
     * @inheritDoc
     */
    public function withProtocolVersion($version)
    {
        // TODO: Implement withProtocolVersion() method.
        $message = clone $this;
        $message->protocolVersion = $version;
        return $message;
    }

    /**
     * @inheritDoc
     */
    public function getHeaders()
    {
        // TODO: Implement getHeaders() method.
        return $this->headers;
    }

    /**
     * @inheritDoc
     */
    public function hasHeader($name)
    {
        // TODO: Implement hasHeader() method.
        foreach ($this->headers as $key => $value) {
            if ($key === $name) {

                return true;
            }
        }

        return false;
    }
        
    /**
     * @inheritDoc
     */
    public function getHeader($name)
    {
        // TODO: Implement getHeader() method.
        foreach ($this->headers as $key => $value) {
            if ($key === $name) {

                return $value;
            }
        }

        return [];
    }

    /**
     * @inheritDoc
     */
    public function getHeaderLine($name)
    {
        // TODO: Implement getHeaderLine() method.
    }

    /**
     * @inheritDoc
     */
    public function withHeader($name, $value)
    {
        // TODO: Implement withHeader() method.
        $message = clone $this;
        foreach ($message->headers as $key => $val){
            if ($key === $name) {

                $message->headers[$key] = $value;
            }
        }
        return $message;


    }

    /**
     * @inheritDoc
     */
    public function withAddedHeader($name, $value)
    {
        // TODO: Implement withAddedHeader() method.
        $message = clone $this;
        $message->headers = array_push($message->headers, [$name => $value] );
        return $message;
    }

    /**
     * @inheritDoc
     */
    public function withoutHeader($name)
    {
        // TODO: Implement withoutHeader() method.
        $message = clone $this;
        unset($message->headers[$name]);
        return $message;
    }

    /**
     * @inheritDoc
     */
    public function getBody()
    {
        // TODO: Implement getBody() method.
    }

    /**
     * @inheritDoc
     */
    public function withBody(StreamInterface $body)
    {
        // TODO: Implement withBody() method.

    }
}