<?php
namespace Framework\Exceptions;

use Framework\Routing\Router;
use http\Message;
use Throwable;

class RouteDoesNotExistException extends \Exception
{
    private $actionName;
    private $method;
    private $controllerName;
    private $path;
    private $error;

    public function __construct(array $error)
    {
        $this->error = $error;
        parent::__construct($message, $code = 404, $previous = null);
    }

    public static function forMissingRoute(array $exception) : self {
        new RouteDoesNotExistException($exception);
    }

    private function setAttribute(array $exception){
        $this->message = $this->createMessage();
        $this->method = $exception[Router::CONFIG_ROUTES_KEY_METHOD];
        $this->controllerName = $exception[Router::CONFIG_ROUTES_KEY_CONTROLLERNAME];
        $this->actionName = $exception[Router::CONFIG_ROUTES_KEY_ACTIONNNAME];
        $this->path = $exception[Router::CONFIG_ROUTES_KEY_PATH];
    }

    /**
     * @return mixed
     */


//    public function getFile()
//    {
//
//    }
    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return mixed
     */
    public function getActionName()
    {
        return $this->actionName;
    }

    /**
     * @return mixed
     */
    public function getControllerName()
    {
        return $this->controllerName;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    private function alert($msg) {
//        $this->alert($message);
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }

    private function createMessage()
    {
        $message = "The route ";
//        $this->message
    }
}