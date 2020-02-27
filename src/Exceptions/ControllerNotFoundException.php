<?php


class ControllerNotFoundException extends Exception
{
    public function errorMessage() {
        return 'Controller not found';
    }
}