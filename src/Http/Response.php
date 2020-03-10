<?php

namespace Framework\Http;

use Framework\Exceptions\StreamNotFoundException;
use Psr\Http\Message\ResponseInterface;

class Response extends Message implements ResponseInterface
{
    /**
     * @var int
     */
    private $statusCode;

    private $location;

    /**
     * Response constructor.
     * @param $body
     * @param string $protocolVersion
     * @param int $statusCode
     * @param null $location
     */
    public function __construct($body, $protocolVersion = "1.1", $statusCode = 200, $location = null)
    {
        parent::__construct($protocolVersion, $body);
        $this->statusCode = $statusCode;
        $this->location = $location;
    }

    public function send(): void
    {
        $this->sendHeaders();
        $this->sendBody();
    }

    private function sendHeaders(): void
    {
        if ($this->location) {
            header($this->location);
        }
        if ($this->headers) {
            foreach ($this->headers as $key => $value) {
                header($key . ": " . implode(',', $value));
            }
        }
    }

    private function sendBody(): void
    {
        try {
            echo $this->getBody()->getContents();
        } catch (StreamNotFoundException $e) {
            $e->getMessage();
        }
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
