<?php

namespace Cos\RestClientBundle\Endpoint;


use Doctrine\Common\Annotations\Reader;

class EndpointLoader
{
    private $reader;

    private $endpointCollection;
    private $endpointFactory;

    public function __construct(Reader $reader, EndpointCollection $endpointCollection, EndpointFactory $endpointFactory)
    {
        $this->reader = $reader;
        $this->endpointCollection = $endpointCollection;
        $this->endpointFactory = $endpointFactory;
    }

    public function load($class)
    {
        $methods = (new \ReflectionClass($class))->getMethods();

        foreach ($methods as $name => $method) {
            $this->doLoad($class, $method, $this->reader->getMethodAnnotations($method));
        }
    }

    private function doLoad($class, \ReflectionMethod $method, array $annotations)
    {
        $endpoint = $this->endpointFactory->create($annotations);
        $this->endpointCollection->add($class, $method->getName(), $endpoint);
    }
}