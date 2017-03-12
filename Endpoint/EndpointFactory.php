<?php

namespace Cos\RestClientBundle\Endpoint;


use Cos\RestClientBundle\Annotation\Endpoint as EndpointAnnotation;
use Cos\RestClientBundle\Annotation\Path;
use Cos\RestClientBundle\Annotation\Query;
use Cos\RestClientBundle\Annotation\QueryMap;
use Cos\RestClientBundle\Annotation\RequestBody;


class EndpointFactory
{
    public function create(array $annotations)
    {
        foreach ($annotations as $key => $annotation) {
            if ($annotation instanceof EndpointAnnotation) {
                $endpoint = new Endpoint($annotation->uri, $annotation->method);
                unset($annotations[$key]);

                return $this->addEndpointExtraData($endpoint, $annotations);
            }
        }

        throw new \InvalidArgumentException("Could not create endpoint! No Endpoint annotation used!");
    }

    private function addEndpointExtraData(Endpoint $endpoint, array $annotations)
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Path) {
                $endpoint->addPath($annotation->name, $annotation->paramName);
            }
            if ($annotation instanceof Query) {
                $endpoint->addQueryParam($annotation->name);
            }
            if ($annotation instanceof RequestBody) {
                $endpoint->setRequestBody($annotation->name);
            }
            if ($annotation instanceof QueryMap) {
                $endpoint->setQueryMap($annotation->name);
            }
        }

        return $endpoint;
    }
}