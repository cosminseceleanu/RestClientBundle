<?php

namespace Cos\RestClientBundle\Request\Options;

use Cos\RestClientBundle\Request\ParametersCollection;
use Cos\RestClientBundle\Request\Request;

interface RequestOptionInterface
{
    public function supports($annotation);

    public function addValue(Request $request, $annotation, ParametersCollection $parameters);
}