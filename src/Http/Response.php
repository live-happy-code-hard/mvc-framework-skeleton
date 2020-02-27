<?php

namespace Framework\Http;

use Psr\Http\Message\ResponseInterface;

class Response extends Message implements ResponseInterface
{
    private $statusCode;

    public function __construct($body, $protocolVersion = "1.1", $statusCode = 200)
    {
        parent::__construct($protocolVersion, $body);
        $this->statusCode = $statusCode;
    }

    public function send(): void
    {
        $this->sendHeaders();
        $this->sendBody();
    }

    private function sendHeaders(): void
    {
        foreach ($this->headers as $key => $value){
            header($key . ": " . implode($value,','));
        }
    }

    private function sendBody(): void
    {
        echo $this->getBody()->getContents();
    }

    /**
     * @inheritDoc
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @inheritDoc
     */
    public function withStatus($code, $reasonPhrase = '')
    {
        $response = clone $this;
        $response->statusCode = $code;

        return $response;
    }

    /**
     * @inheritDoc
     */
    public function getReasonPhrase()
    {
        // TODO: Implement getReasonPhrase() method.
    }
}
