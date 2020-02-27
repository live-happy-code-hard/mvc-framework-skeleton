<?php


namespace Framework\Http;

use Psr\Http\Message\UriInterface;

class Uri implements UriInterface
{
    /**
     * @var string
     */
    private $scheme;

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $host;

    /**
     * @var int|null
     */
    private $port;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $query;

    /**
     * @var string
     */
    private $fragment;

    /**
     * Uri constructor.
     * @param string $scheme
     * @param string $user
     * @param string $password
     * @param string $host
     * @param int|null $port
     * @param string $path
     * @param string $query
     * @param string $fragment
     */
    public function __construct
    (
        string $scheme,
        string $host,
        ?int $port,
        string $path,
        string $query,
        string $user='',
        string $password='',
        string $fragment='')
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

    public static function createFromGlobals()
    {
        $scheme = $_SERVER["REQUEST_SCHEME"];
        $host = $_SERVER["HTTP_HOST"];
        $port = intval($_SERVER["SERVER_PORT"]);
        $path = explode('?',$_SERVER["REQUEST_URI"])[0];
        $query = $_SERVER["QUERY_STRING"];

        return new self($scheme, $host, $port,$path,$query);
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
        $authority = '';
        if ($this->getUserInfo() !== '') {
            $authority .= $this->getUserInfo() . "@";
        }
        $authority .= $this->getHost();
        if ($this->getPort()) {
            $authority .= ':' . $this->getPort();
        }
        return $authority;
    }

    /**
     * @inheritDoc
     */
    public function getUserInfo()
    {
        if ($this->user !== '' &&
            $this->password === '') {
            return $this->user;
        }
        if ($this->user === '' &&
            $this->password === '') {
            return '';
        }

        return $this->user . ':' . $this->password;
    }

    /**
     * @inheritDoc
     */
    public function getHost()
    {
        return strtolower($this->host);
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
        $request = clone $this;
        $request->scheme = $scheme;

        return $request;
    }

    /**
     * @inheritDoc
     */
    public function withUserInfo($user, $password = null)
    {
        $request = clone $this;
        $request->user = $user;
        if ($password == null) {
            $this->password = '';
        }

        return $request;
    }

    /**
     * @inheritDoc
     */
    public function withHost($host)
    {
        $request = clone $this;
        $request->host = $host;

        return $request;
    }

    /**
     * @inheritDoc
     */
    public function withPort($port)
    {
        $request = clone $this;
        $request->port = $port;

        return $request;
    }

    /**
     * @inheritDoc
     */
    public function withPath($path)
    {
        $request = clone $this;
        $request->path = $path;

        return $request;
    }

    /**
     * @inheritDoc
     */
    public function withQuery($query)
    {
        $request = clone $this;
        $request->query = $query;

        return $request;
    }

    /**
     * @inheritDoc
     */
    public function withFragment($fragment)
    {
        $request = clone $this;
        $request->fragment = $fragment;

        return $request;
    }

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        $uri = '';
        if ($this->getScheme() !== '') {
            $uri .= $this->getScheme() . ':';
        }
        if ($this->getAuthority() !== '') {
            $uri .= '//' . $this->getAuthority();
        }
        if ($this->getPath() !== '' && $this->getPath()[0] !== '/') {
            $uri .= '/';
        }
        $uri .= $this->getPath();
        if ($this->getQuery() !== '') {
            $uri .= '?' . $this->getQuery();
        }
        if ($this->getFragment() !== '') {
            $uri .= '#' . $this->getFragment();
        }

        return $uri;
    }
}