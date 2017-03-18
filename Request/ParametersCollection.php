<?php

namespace Cos\RestClientBundle\Request;


use Cos\RestClientBundle\Exception\ParameterNotSetException;

class ParametersCollection extends \ArrayObject
{
    public function get($key)
    {
        if (!isset($this[$key])) {
            throw new ParameterNotSetException("No parameter with {$key} found");
        }

        return $this[$key];
    }
}