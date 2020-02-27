<?php


namespace Framework\Http;

use Psr\Http\Message\StreamInterface;

class Stream implements StreamInterface
{
    const DEFAULT_MEMORY = 5 * 1024 * 1024;
    const DEFAULT_MODE = 'r+';

    /**
     * @var false|resource
     */
    private $stream;

    /**
     * @var int
     */
    private $size;

    /**
     * @var bool
     */
    private $writable;

    /**
     * @var bool
     */
    private $readable;

    /**
     * @var bool
     */
    private $seekable;

    /**
     * Stream constructor.
     * @param $handler
     * @param int|null $size
     */
    public function __construct($handler,int $size = null)
    {
        $this->stream = $handler;
        $this->size = $size;
        $this->writable = $this->readable = $this->seekable = true;
    }

    /**
     * @param string $content
     * @return static
     */
    public static function createFromString(string $content): self
    {
        $stream = fopen(sprintf("php://temp/maxmemory:%s", self::DEFAULT_MEMORY), self::DEFAULT_MODE);
        fwrite($stream,$content);
        return new self($stream,strlen($content));
    }

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        if(!isset($this->stream)){
            throw new \RuntimeException("Stream not found");
        }
        $this->rewind();
        fread($this->stream, $this->size);
    }

    /**
     * @inheritDoc
     */
    public function close()
    {
        $this->writable = $this->readable = $this->seekable = false;
        if(!isset($this->stream)){
            throw new \RuntimeException("Stream not found");
        }
        fclose($this->stream);
    }

    /**
     * @inheritDoc
     */
    public function detach()
    {
        if (!isset($this->stream))
            return null;

        $result = $this->stream;
        unset($this->stream);

        $this->size = null;
        $this->writable = $this->readable = $this->seekable = false;

        return $result;
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
        if (!isset($this->stream)) {
            throw new \RuntimeException("Stream not found");
        }

        return ftell($this->stream);
    }

    /**
     * @inheritDoc
     */
    public function eof()
    {
        if (!isset($this->stream)) {
            throw new \RuntimeException("Stream not found");
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
        if(!isset($this->stream)){
            throw new \RuntimeException("Stream not found");
        }

        fseek($this->stream, $offset, $whence);
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        if(!isset($this->stream)){
            throw new \RuntimeException("Stream not found");
        }

        fseek($this->stream, 0);
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
            return null;
        }
        return fwrite($this->stream, $string);
    }

    /**
     * @inheritDoc
     */
    public function isReadable()
    {
        return $this->seekable;
    }

    /**
     * @inheritDoc
     */
    public function read($length)
    {
        if(!isset($this->stream)){
            throw new \RuntimeException("Stream not found");
        }

        return fread($this->stream, $length);
    }

    /**
     * @inheritDoc
     */
    public function getContents()
    {
        $this->rewind();
        if(!isset($this->stream)){
            throw new \RuntimeException("Stream not found");
        }

        return stream_get_contents($this->stream);
    }

    /**
     * @inheritDoc
     */
    public function getMetadata($key = null)
    {
        if(!isset($this->stream)){
            throw new \RuntimeException("Stream not found");
        }

        return stream_get_meta_data($this->stream);
    }
}