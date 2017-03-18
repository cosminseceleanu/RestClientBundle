<?php

namespace Cos\RestClientBundle\Endpoint;


use Cos\RestClientBundle\Annotation\Client;
use Cos\RestClientBundle\Exception\InvalidConfigurationException;
use Cos\RestClientBundle\Exception\ParameterNotSetException;
use Doctrine\Common\Annotations\Reader;

class EndpointLoader
{
    private $reader;

    private $endpointCollection;
    private $endpointFactory;
    private $clients;

    public function __construct(Reader $reader, EndpointCollection $endpointCollection, EndpointFactory $endpointFactory, array $clients)
    {
        $this->reader = $reader;
        $this->endpointCollection = $endpointCollection;
        $this->endpointFactory = $endpointFactory;
        $this->clients = $clients;
    }

    public function load($class)
    {
        if ($this->endpointCollection->has($class)) {
            return;
        }
        $refectionClass = new \ReflectionClass($class);
        $methods = $refectionClass->getMethods();
        $baseUri = $this->getBaseUri($refectionClass);
        foreach ($methods as $name => $method) {
            $this->doLoad($baseUri, $class, $method, $this->reader->getMethodAnnotations($method));
        }
    }

    private function doLoad($baseUri, $class, \ReflectionMethod $method, array $annotations)
    {
        $endpoint = $this->endpointFactory->create($baseUri, $annotations);
        $this->endpointCollection->add($class, $method->getName(), $endpoint);
    }

    private function getBaseUri(\ReflectionClass $class)
    {
        $annotations = $this->reader->getClassAnnotations($class);
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Client) {
                return $this->getClientBaseUri($annotation->name);
            }
        }
        throw new InvalidConfigurationException("No client was specified for {$class->getName()}");
    }

    private function getClientBaseUri($clientName)
    {
        if (!isset($this->clients[$clientName])) {
            throw new ParameterNotSetException("No client with name {$clientName} was configured");
        }

        return $this->clients[$clientName]['baseUri'];
    }
}