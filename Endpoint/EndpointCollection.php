<?php

namespace Cos\RestClientBundle\Endpoint;


class EndpointCollection
{
    /**
     * @var Endpoint[]
     */
    private $endpoints = [];

    public function add($class, $method, Endpoint $endpoint)
    {
        $this->endpoints[$class][$method] = $endpoint;
    }

    /**
     * @return Endpoint
     */
    public function get($class, $method)
    {
        if (!isset($this->endpoints[$class][$method])) {
            throw new \InvalidArgumentException(sprintf("No endpoint was configured for class %s", $class));
        }

        return $this->endpoints[$class][$method];
    }

    public function has($class)
    {
        return isset($this->endpoints[$class]);
    }
}