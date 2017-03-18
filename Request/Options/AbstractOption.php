<?php

namespace Cos\RestClientBundle\Request\Options;


use Cos\RestClientBundle\Request\ParametersCollection;
use Cos\RestClientBundle\Request\Request;

abstract class AbstractOption implements RequestOptionInterface
{
    public function addValue(Request $request, $annotation, ParametersCollection $parameters)
    {
        $request->setRequestOption($this->getGuzzleOption(), $this->getValue($annotation, $parameters));
    }

    abstract protected function getGuzzleOption();
    abstract protected function getValue($annotation, ParametersCollection $parameters);
}