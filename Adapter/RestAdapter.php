<?php

namespace Cos\RestClientBundle\Adapter;

use Cos\RestClientBundle\Endpoint\Endpoint;
use Cos\RestClientBundle\Endpoint\EndpointCollection;
use Cos\RestClientBundle\Request\RequestBuilder;
use GuzzleHttp\ClientInterface;
use ProxyManager\Factory\RemoteObject\AdapterInterface;

class RestAdapter implements AdapterInterface
{
    private $client;
    private $endpointCollection;
    private $requestBuilder;

    public function __construct(ClientInterface $client, EndpointCollection $endpointCollection, RequestBuilder $requestBuilder)
    {
        $this->client = $client;
        $this->endpointCollection = $endpointCollection;
        $this->requestBuilder = $requestBuilder;
    }

    public function call($wrappedClass, $method, array $params = array())
    {
        $keyValueParameters = $this->getKeyValueMethodParams($wrappedClass, $method, $params);
        $endpoint =  $this->endpointCollection->get($wrappedClass, $method);
        $request  = $this->requestBuilder->setEndpoint($endpoint)
            ->setParameters($keyValueParameters)
            ->build();
        $response = $this->client->request($request->getMethod(), $request->getUri(), $request->getRequestOptions());

        return $response;
    }

    private function getKeyValueMethodParams($wrappedClass, $method, array $params)
    {
        if (empty($params)) {
            return $params;
        }
        $keyValueParameters = array();
        $reflectionMethod = (new \ReflectionClass($wrappedClass))->getMethod($method);
        foreach ($reflectionMethod->getParameters() as $parameter) {
            $keyValueParameters[$parameter->getName()] = $params[$parameter->getPosition()];
        }

        return $keyValueParameters;
    }
}