<?php


class RouteNotFoundException extends Exception
{
    public function errorMessage()
    {
        return 'Route invalid';
    }
}