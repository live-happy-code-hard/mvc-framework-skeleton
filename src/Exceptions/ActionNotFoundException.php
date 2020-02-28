<?php


namespace Framework\Exceptions;


use Exception;
use Throwable;

class ActionNotFoundException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}