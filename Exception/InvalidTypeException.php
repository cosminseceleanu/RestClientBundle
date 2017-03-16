<?php

namespace Cos\RestClientBundle\Exception;


use Exception;

class InvalidTypeException extends \Exception
{
    public function __construct($expectedType, $giveType, $code = 0, Exception $previous = null)
    {
        $message = "Expected argument of type {$expectedType}, {$giveType} given";
        parent::__construct($message, $code, $previous);
    }
}