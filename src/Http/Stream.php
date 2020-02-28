<?php


namespace Framework\Http;

use Framework\Exceptions\StreamNotFoundException;
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
    public function __construct($handler, ?int $size = null)
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
        fwrite($stream, $content);

        return new self($stream, strlen($content));
    }

    /**
     * @inheritDoc
     * @throws StreamNotFoundException
     */
    public function __toString()
    {
        if (!isset($this->stream)) {
            throw new StreamNotFoundException("Stream not found");
        }
        $this->rewind();
        fread($this->stream, $this->size);
    }

    /**
     * @inheritDoc
     * @throws StreamNotFoundException
     */
    public function close()
    {
        $this->writable = $this->readable = $this->seekable = false;
        if (!isset($this->stream)) {
            throw new StreamNotFoundException("Stream not found");
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
     * @throws StreamNotFoundException
     */
    public function tell()
    {
        if (!isset($this->stream)) {
            throw new StreamNotFoundException("Stream not found");
        }

        return ftell($this->stream);
    }

    /**
     * @inheritDoc
     * @throws StreamNotFoundException
     */
    public function eof()
    {
        if (!isset($this->stream)) {
            throw new StreamNotFoundException("Stream not found");
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
     * @throws StreamNotFoundException
     */
    public function seek($offset, $whence = SEEK_SET)
    {
        if (!isset($this->stream)) {
            throw new StreamNotFoundException("Stream not found");
        }
        fseek($this->stream, $offset, $whence);
    }

    /**
     * @inheritDoc
     * @throws StreamNotFoundException
     */
    public function rewind()
    {
        if (!isset($this->stream)) {
            throw new StreamNotFoundException("Stream not found");
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
     * @throws StreamNotFoundException
     */
    public function read($length)
    {
        if (!isset($this->stream)) {
            throw new StreamNotFoundException("Stream not found");
        }

        return fread($this->stream, $length);
    }

    /**
     * @inheritDoc
     * @throws StreamNotFoundException
     */
    public function getContents()
    {
        $this->rewind();
        if (!isset($this->stream)) {
            throw new StreamNotFoundException("Stream not found");
        }

        return stream_get_contents($this->stream);
    }

    /**
     * @inheritDoc
     * @throws StreamNotFoundException
     */
    public function getMetadata($key = null)
    {
        if (!isset($this->stream)) {
            throw new StreamNotFoundException("Stream not found");
        }

        return stream_get_meta_data($this->stream);
    }
}
