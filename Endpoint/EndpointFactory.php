<?php

namespace Cos\RestClientBundle\Endpoint;


use Cos\RestClientBundle\Annotation\Endpoint as EndpointAnnotation;
use Cos\RestClientBundle\Annotation\Form;
use Cos\RestClientBundle\Annotation\Json;
use Cos\RestClientBundle\Annotation\Multipart;
use Cos\RestClientBundle\Annotation\Path;
use Cos\RestClientBundle\Annotation\Query;
use Cos\RestClientBundle\Annotation\QueryMap;
use Cos\RestClientBundle\Annotation\RequestBody;


class EndpointFactory
{
    public function create($baseUri, array $annotations)
    {
        foreach ($annotations as $key => $annotation) {
            if ($annotation instanceof EndpointAnnotation) {
                $uri = $baseUri . $annotation->uri;
                $endpoint = new Endpoint($uri, $annotation->method);
                unset($annotations[$key]);

                return $this->addEndpointExtraData($endpoint, $annotations);
            }
        }

        throw new \InvalidArgumentException("Could not create endpoint! No Endpoint annotation used!");
    }

    private function addEndpointExtraData(Endpoint $endpoint, array $annotations)
    {
        /** @ToDo refactor this */
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
            if ($annotation instanceof Json) {
                $endpoint->setJson($annotation->name);
            }
            if ($annotation instanceof Form) {
                $endpoint->setForm($annotation->name);
            }
            if ($annotation instanceof Multipart) {
                $endpoint->setMultipart($annotation->name);
            }
        }

        return $endpoint;
    }
}