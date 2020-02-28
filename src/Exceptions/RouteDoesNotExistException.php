<?php
namespace Framework\Exceptions;

use Framework\Routing\RouteMatch;

class RouteDoesNotExistException extends \Exception
{
    private $actionName;
    private $method;
    private $controllerName;
    private $path;
    protected $message;
    private $error;

    public function __construct(RouteMatch $error)
    {
        $this->setAttribute($error);
        $this->error = $error;
        parent::__construct($this->message, $code = 404, $previous = null);
    }

    public static function forMissingRoute(RouteMatch $exception, string $path){

        return new self($exception);
    }

    private function setAttribute(RouteMatch $exception){
        $this->message = $this->createMessage();
        $this->method = $exception->getMethod();
        $this->controllerName = $exception->getControllerName();
        $this->actionName = $exception->getActionName();
    }

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