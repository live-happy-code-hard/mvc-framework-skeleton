<?php

namespace Framework\Http;

use Psr\Http\Message\StreamInterface;

class Response extends Message
{
    private $statusCode;
    private $reasonPhrase;

    public function __construct
    (
        StreamInterface $body,
        string $protocolVersion = '',
        array $headers = [],
        int $statusCode = 200,
        string $reasonPhrase =''
    )
    {
        $this->statusCode= $statusCode;
        $this->reasonPhrase = $reasonPhrase;
        parent::__construct($protocolVersion, $headers, $body);
    }


    public function send(): void
    {
        $this->sendHeaders();
        $this->sendBody();
    }

    private function sendHeaders(): void
    {
        foreach ($this->getHeaders() as $key => $value){
            header($key. ": ". implode($value, ','));
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
        if (isset($this->reasonPhrase)) {
            return $this->reasonPhrase;
        }

        return "";
    }
}
