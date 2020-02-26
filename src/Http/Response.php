<?php

namespace Framework\Http;

class Response extends Message
{
    public function send(): void
    {
        $this->sendHeaders();
        $this->sendBody();
    }

    private function sendHeaders(): void
    {
        // TODO: use header() PHP function here to send the response headers added to this response
    }

    private function sendBody(): void
    {
        // TODO: just print the content of the response
    }

    // TODO: implement methods declared by ResponseInterface

     /**
     * @inheritDoc
     */
    public function getStatusCode()
    {
        // TODO: Implement getStatusCode() method.
    }

    /**
     * @inheritDoc
     */
    public function withStatus($code, $reasonPhrase = '')
    {
        // TODO: Implement withStatus() method.
    }

    /**
     * @inheritDoc
     */
    public function getReasonPhrase()
    {
        // TODO: Implement getReasonPhrase() method.
    }
}
