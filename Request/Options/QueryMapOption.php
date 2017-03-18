<?php

namespace Cos\RestClientBundle\Request\Options;

use Cos\RestClientBundle\Annotation\QueryMap;
use Cos\RestClientBundle\Request\ParametersCollection;
use GuzzleHttp\RequestOptions;

class QueryMapOption extends ArrayOption
{
    public function supports($annotation)
    {
        return $annotation instanceof QueryMap;
    }

    protected function getGuzzleOption()
    {
        return RequestOptions::QUERY;
    }

    protected function getValue($annotation, ParametersCollection $parameters)
    {
        $value = $parameters->get($annotation->name);
        $this->validateArray($value);

        return $value;
    }
}