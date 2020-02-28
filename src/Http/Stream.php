<?php


namespace Framework\Http;


use Psr\Http\Message\StreamInterface;

class Stream implements StreamInterface
{
    const DEFAULT_MEMORY = 5 * 1024 * 1024;
    CONST DEFAULT_MODE = "r+";

    private $stream;
    private $size;
    private $writable;
    private $readable;
    private $seekable;

    public function __construct($handler, ?int $size = null)
    {
        $this->stream = $handler;
        $this->size = $size;
        $this->writable = $this->readable = $this->seekable = true;
    }

    public static function createFromString(string $content): self
    {
        $stream = fopen(sprintf("php://temp/maxmemory:%s", self::DEFAULT_MEMORY), self::DEFAULT_MODE);
        fwrite($stream, $content);
        return new self($stream, strlen($content));
    }

    /**
     * @return false|string
     */
    public function __toString()
    {
        //make sure with fseek() to 0 pointer
        //
        //read from stream with fread()

        return $this->getContents();
    }

    /**
     * @inheritDoc
     */
    public function close()
    {

        return fclose($this->stream);
    }

    /**
     * @inheritDoc
     */
    public function detach()
    {
        //is close but chech
        if (!isset($this->stream)) {

            return null;
        }

        $message = clone $this;

        unset($message->stream);
        $message->size = 0;
        $message->readable = $this->writable = $this->seekable = false;

        return $message;
    }

    /**
     * @inheritDoc
     */
    public function getSize()
    {

        return $this->size;
    }

    /**
     * @inheritDoc
     */
    public function tell()
    {
        //tell us where is the pointer

        return ftell($this->stream);
    }

    /**
     * @inheritDoc
     */
    public function eof()
    {
        if (!isset($this->stream)) {
            return true;
        }

        return feof($this->stream);
    }

    /**
     * @inheritDoc
     */
    public function isSeekable()
    {

        return $this->seekable;
    }

    /**
     * @inheritDoc
     */
    public function seek($offset, $whence = SEEK_SET)
    {
        //tell the stream

        return fseek($this->stream, $offset);
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        //mean seek(0);

        return $this->seek(0);
    }

    /**
     * @inheritDoc
     */
    public function isWritable()
    {

        return $this->writable;
    }

    /**
     * @inheritDoc
     */
    public function write($string)
    {
        if (!isset($this->stream)) {
            return 0;
        }
        if (!$this->isWritable()) {
            return 0;
        }

        return fwrite($this->stream, $string);
    }

    /**
     * @inheritDoc
     */
    public function isReadable()
    {

        return $this->readable;
    }

    /**
     * @inheritDoc
     */
    public function read($length)
    {
        if (!isset($this->stream)) {
            return "";
        }
        if ($this->isReadable()) {
            return "";
        }

        return fread($this->stream, $length);
    }

    /**
     * @inheritDoc
     */
    public function getContents()
    {
        $this->rewind();
        return stream_get_contents($this->stream);
    }

    /**
     * @inheritDoc
     */
    public function getMetadata($key = null)
    {

        return stream_get_meta_data($this->stream);
    }
}