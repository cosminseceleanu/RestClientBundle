<?php

namespace Cos\RestClientBundle\Endpoint;


use Cos\RestClientBundle\Annotation\Path;
use Cos\RestClientBundle\Exception\InvalidConfigurationException;

class Endpoint
{
    private $uri;

    private $httpMethod;

    private $annotations;

    public function __construct($uri, $method = 'get', array $annotations = array())
    {
        $this->uri = $uri;
        $this->httpMethod = $method;
        $this->annotations = $annotations;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getAnnotations()
    {
        return $this->annotations;
    }

    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    public function getPath($name)
    {
        foreach ($this->annotations as $annotation) {
            if ($annotation instanceof Path && $annotation->name === $name) {
                return $annotation;
            }
        }

        throw new InvalidConfigurationException("No @Path annotation was set for name {$name}");
    }
}