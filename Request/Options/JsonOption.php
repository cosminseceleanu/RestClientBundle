<?php

namespace Cos\RestClientBundle\Request\Options;


use Cos\RestClientBundle\Annotation\Json;
use Cos\RestClientBundle\Request\ParametersCollection;
use GuzzleHttp\RequestOptions;

class JsonOption extends AbstractOption
{
    public function supports($annotation)
    {
        return $annotation instanceof Json;
    }

    protected function getGuzzleOption()
    {
        return RequestOptions::JSON;
    }

    protected function getValue($annotation, ParametersCollection $parameters)
    {
        return $parameters->get($annotation->name);
    }
}