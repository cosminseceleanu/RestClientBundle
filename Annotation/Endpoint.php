<?php

namespace Cos\RestClientBundle\Annotation;

/**
 * @Annotation
 * @Target("METHOD")
 */
class Endpoint
{
    public $uri;

    public $method;

    public function __construct(array $parameters)
    {
        $this->uri = $parameters['uri'];

        $this->method = isset($parameters['method']) ? $parameters['method'] : 'get';
    }
}