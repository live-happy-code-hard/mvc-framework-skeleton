<?php


namespace Framework\Http;


use Psr\Http\Message\StreamInterface;

class Stream implements StreamInterface
{
    const DEFAULT_MEMORY = 5*1024*1024;
    CONST DEFAULT_MODE = "r+";

    private $stream;
    private $size;
    private $writable;
    private $readable;
    private $seekable;

    public function __construct(string $content)
    {
        $this->stream = fopen(sprintf("php://temp/maxmemory:%D",self::DEFAULT_MEMORY), self::DEFAULT_MODE);

        $this->size = mb_strlen($content);

        $this->writable = $this->readable = $this->seekable = true;
    }

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        // TODO: Implement __toString() method.
        //make sure with fseek() to 0 pointer
        //
        //read from stream with fread()
        $this->rewind();

        return fread($this->stream,$this->size);
    }

    /**
     * @inheritDoc
     */
    public function close()
    {
        // TODO: Implement close() method.
        return fclose($this->stream);
    }

    /**
     * @inheritDoc
     */
    public function detach()
    {
        // TODO: Implement detach() method.
        //is close but chech
        if ($this->stream){
            return $this->close();
        }
    }

    /**
     * @inheritDoc
     */
    public function getSize()
    {
        // TODO: Implement getSize() method.
        return $this->size;
    }

    /**
     * @inheritDoc
     */
    public function tell()
    {
        // TODO: Implement tell() method.
        //tell us where is the pointer
        return $this->seek(0, SEEK_CUR);

    }

    /**
     * @inheritDoc
     */
    public function eof()
    {
        // TODO: Implement eof() method.
        return feof($this->stream);
    }

    /**
     * @inheritDoc
     */
    public function isSeekable()
    {
        // TODO: Implement isSeekable() method.
        return $this->seekable;
    }

    /**
     * @inheritDoc
     */
    public function seek($offset, $whence = SEEK_SET)
    {
        // TODO: Implement seek() method.
        //tell the stream
        return fseek($this->stream, $offset, $whence);
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        // TODO: Implement rewind() method.
        //mean seek(0);
        return $this->seek(0);
    }

    /**
     * @inheritDoc
     */
    public function isWritable()
    {
        // TODO: Implement isWritable() method.
        return $this->writable;
    }

    /**
     * @inheritDoc
     */
    public function write($string)
    {
        // TODO: Implement write() method.
        fwrite($this->stream, $string);
    }

    /**
     * @inheritDoc
     */
    public function isReadable()
    {
        // TODO: Implement isReadable() method.
        return $this->readable;
    }

    /**
     * @inheritDoc
     */
    public function read($length)
    {
        // TODO: Implement read() method.
        return fread($this->stream, $length);
    }

    /**
     * @inheritDoc
     */
    public function getContents()
    {
        // TODO: Implement getContents() method.
        return stream_get_contents($this->stream);
    }

    /**
     * @inheritDoc
     */
    public function getMetadata($key = null)
    {
        // TODO: Implement getMetadata() method.
        return stream_get_meta_data($this->stream);
    }
}