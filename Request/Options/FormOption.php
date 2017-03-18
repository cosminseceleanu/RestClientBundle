<?php

namespace Cos\RestClientBundle\Request\Options;


use Cos\RestClientBundle\Annotation\Form;
use Cos\RestClientBundle\Request\ParametersCollection;
use GuzzleHttp\RequestOptions;

class FormOption extends ArrayOption
{
    protected function getGuzzleOption()
    {
        return RequestOptions::FORM_PARAMS;
    }

    protected function getValue($annotation, ParametersCollection $parameters)
    {
        $value = $parameters->get($annotation->name);
        $this->validateArray($value);

        return $value;
    }

    public function supports($annotation)
    {
        return $annotation instanceof Form;
    }
}