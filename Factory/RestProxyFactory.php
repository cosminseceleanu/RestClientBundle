<?php

namespace Cos\RestClientBundle\Factory;


use Cos\RestClientBundle\Endpoint\EndpointLoader;
use ProxyManager\Factory\RemoteObject\AdapterInterface;
use ProxyManager\Factory\RemoteObjectFactory;

class RestProxyFactory
{
    private $restAdapter;

    private $loader;

    public function __construct(AdapterInterface $restAdapter, EndpointLoader $loader)
    {
        $this->restAdapter = $restAdapter;
        $this->loader = $loader;
    }

    public function create($interface)
    {
        $this->loader->load($interface);
        $factory = new RemoteObjectFactory($this->restAdapter);

        return $factory->createProxy($interface);
    }
}