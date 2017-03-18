<?php

namespace Cos\RestClientBundle\Endpoint;

use Cos\RestClientBundle\Annotation\Endpoint as EndpointAnnotation;

class EndpointFactory
{
    public function create($baseUri, array $annotations)
    {
        foreach ($annotations as $key => $annotation) {
            if ($annotation instanceof EndpointAnnotation) {
                $uri = $baseUri . $annotation->uri;
                $endpoint = new Endpoint($uri, $annotation->method, $annotations);

                return $endpoint;
            }
        }

        throw new \InvalidArgumentException("Could not create endpoint! No Endpoint annotation used!");
    }
}