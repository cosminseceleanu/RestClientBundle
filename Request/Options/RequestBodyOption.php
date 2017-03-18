<?php

namespace Cos\RestClientBundle\Request\Options;

use Cos\RestClientBundle\Annotation\RequestBody;
use Cos\RestClientBundle\Request\ParametersCollection;
use GuzzleHttp\RequestOptions;

class RequestBodyOption extends AbstractOption
{
    public function supports($annotation)
    {
        return $annotation instanceof RequestBody;
    }

    protected function getGuzzleOption()
    {
        return RequestOptions::BODY;
    }

    protected function getValue($annotation, ParametersCollection $parameters)
    {
        return $parameters->get($annotation->name);
    }
}