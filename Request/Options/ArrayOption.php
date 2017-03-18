<?php

namespace Cos\RestClientBundle\Request\Options;


use Cos\RestClientBundle\Exception\InvalidTypeException;

abstract class ArrayOption extends AbstractOption
{
    protected function validateArray($value)
    {
        if (is_array($value)) {
            return;
        }

        throw new InvalidTypeException(gettype(array()), gettype($value));
    }
}