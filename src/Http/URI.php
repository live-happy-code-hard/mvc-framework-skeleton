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
        string $scheme,
        string $user,
        string $password,
        string $host,
        string $port,
        string $path,
        string $query,
        string $fragment
    )
    {
        $this->scheme = $scheme;
        $this->user = $user;
        $this->password = $password;
        $this->host = $host;
        $this->port=$port;
        $this->path= $path;
        $this->query= $query;
        $this->fragment=$fragment;
    }

    /**
     * @inheritDoc
     */
    public function getScheme()
    {
        // TODO: Implement getScheme() method.
        return $this->scheme;
    }

    /**
     * @inheritDoc
     */
    public function getAuthority()
    {
        // TODO: Implement getAuthority() method.
        return $this->getUserInfo()."@".$this->getHost().":". $this->getPort();
    }

    /**
     * @inheritDoc
     */
    public function getUserInfo()
    {
        // TODO: Implement getUserInfo() method.
        return $this->user.":".$this->password;
    }

    /**
     * @inheritDoc
     */
    public function getHost()
    {
        // TODO: Implement getHost() method.
        return $this->host;
    }

    /**
     * @inheritDoc
     */
    public function getPort()
    {
        // TODO: Implement getPort() method.
        return $this->port;
    }

    /**
     * @inheritDoc
     */
    public function getPath()
    {
        // TODO: Implement getPath() method.
        return $this->path;
    }

    /**
     * @inheritDoc
     */
    public function getQuery()
    {
        // TODO: Implement getQuery() method.
        return $this->query;
    }

    /**
     * @inheritDoc
     */
    public function getFragment()
    {
        // TODO: Implement getFragment() method.
        return $this->fragment;
    }

    /**
     * @inheritDoc
     */
    public function withScheme($scheme)
    {
        // TODO: Implement withScheme() method.
        $uri = clone $this;
        $uri->scheme = $scheme;

        return $uri;
    }

    /**
     * @inheritDoc
     */
    public function withUserInfo($user, $password = null)
    {
        // TODO: Implement withUserInfo() method.
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
        // TODO: Implement withHost() method.
        $uri = clone $this;
        $uri->host = $host;

        return $uri;
    }

    /**
     * @inheritDoc
     */
    public function withPort($port)
    {
        // TODO: Implement withPort() method.
        $uri = clone $this;
        $uri->port = $port;

        return $uri;

    }

    /**
     * @inheritDoc
     */
    public function withPath($path)
    {
        // TODO: Implement withPath() method.
        $uri = clone $this;
        $uri->path = $path;

        return $uri;

    }

    /**
     * @inheritDoc
     */
    public function withQuery($query)
    {
        // TODO: Implement withQuery() method.
        $uri = clone $this;
        $uri->query = $query;

        return $uri;
    }

    /**
     * @inheritDoc
     */
    public function withFragment($fragment)
    {
        // TODO: Implement withFragment() method.
        $uri = clone $this;
        $uri->fragment = $fragment;

        return $uri;
    }

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->getScheme()."://".$this->getAuthority().$this->getPath()."?".$this->getQuery()."#".$this->getFragment();
    }
}