<?php

namespace Cos\RestClientBundle\Request\Options;


use Cos\RestClientBundle\Annotation\Multipart;
use Cos\RestClientBundle\Request\ParametersCollection;
use GuzzleHttp\RequestOptions;

class MultipartOption extends ArrayOption
{
    protected function getGuzzleOption()
    {
        return RequestOptions::MULTIPART;
    }

    protected function getValue($annotation, ParametersCollection $parameters)
    {
        $value = $parameters->get($annotation->name);
        $this->validateArray($value);

        return $value;
    }

    public function supports($annotation)
    {
        return $annotation instanceof Multipart;
    }
}