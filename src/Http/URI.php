<?php


namespace Framework\Http;


use Psr\Http\Message\UriInterface;

class URI implements UriInterface
{
    private $scheme;
    private $user;
    private $password;
    private $host;
    private $port;
    private $path;
    private $query;
    private $fragment;

    public function __construct
    (
        string $host,
        ?int $port = null,
        string $path = '',
        string $query = '',
        string $scheme = '',
        string $user = '',
        string $password = '',
        string $fragment = ''
    )
    {
        $this->scheme = $scheme;
        $this->user = $user;
        $this->password = $password;
        $this->host = $host;
        $this->port = $port;
        $this->path = $path;
        $this->query = $query;
        $this->fragment = $fragment;
    }

    public static function createUriFromGlobals()
    {
            $host = $_SERVER['HTTP_HOST'];
            $port =$_SERVER['SERVER_PORT'];
            $path =$_SERVER['REQUEST_URI'];
            $query =$_SERVER['QUERY_STRING'];
            $scheme =$_SERVER['REQUEST_SCHEME'];

            return new self($host,$port,$path,$query,$scheme);
    }

    /**
     * @inheritDoc
     */
    public function getScheme()
    {

        return $this->scheme;
    }

    /**
     * @inheritDoc
     */
    public function getAuthority()
    {

        return $this->getUserInfo() . "@" . $this->getHost() . ":" . $this->getPort();
    }

    /**
     * @inheritDoc
     */
    public function getUserInfo()
    {

        return $this->user . ":" . $this->password;
    }

    /**
     * @inheritDoc
     */
    public function getHost()
    {

        return $this->host;
    }

    /**
     * @inheritDoc
     */
    public function getPort()
    {

        return $this->port;
    }

    /**
     * @inheritDoc
     */
    public function getPath()
    {

        return $this->path;
    }

    /**
     * @inheritDoc
     */
    public function getQuery()
    {

        return $this->query;
    }

    /**
     * @inheritDoc
     */
    public function getFragment()
    {

        return $this->fragment;
    }

    /**
     * @inheritDoc
     */
    public function withScheme($scheme)
    {
        $uri = clone $this;
        $uri->scheme = $scheme;

        return $uri;
    }

    /**
     * @inheritDoc
     */
    public function withUserInfo($user, $password = null)
    {
        $uri = clone $this;
        $uri->user = $user;
        $uri->password = $password;

        return $uri;
    }

    /**
     * @inheritDoc
     */
    public function withHost($host)
    {
        $uri = clone $this;
        $uri->host = $host;

        return $uri;
    }

    /**
     * @inheritDoc
     */
    public function withPort($port)
    {
        $uri = clone $this;
        $uri->port = $port;

        return $uri;

    }

    /**
     * @inheritDoc
     */
    public function withPath($path)
    {
        $uri = clone $this;
        $uri->path = $path;

        return $uri;

    }

    /**
     * @inheritDoc
     */
    public function withQuery($query)
    {
        $uri = clone $this;
        $uri->query = $query;

        return $uri;
    }

    /**
     * @inheritDoc
     */
    public function withFragment($fragment)
    {
        $uri = clone $this;
        $uri->fragment = $fragment;

        return $uri;
    }

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        //validation
        return $this->getScheme() . "://" . $this->getAuthority() . $this->getPath() . "?" . $this->getQuery() . "#" . $this->getFragment();
    }
}