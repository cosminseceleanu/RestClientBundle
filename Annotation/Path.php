<?php

namespace Cos\RestClientBundle\Annotation;

/**
 * @Annotation
 * @Target("METHOD")
 */
class Path extends AbstractParam
{
    public $paramName;
}