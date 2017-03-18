<?php

namespace Cos\RestClientBundle\Request\Options;


use Cos\RestClientBundle\Annotation\Query;
use Cos\RestClientBundle\Request\ParametersCollection;
use Cos\RestClientBundle\Request\Request;
use GuzzleHttp\RequestOptions;

class QueryOption implements RequestOptionInterface
{
    public function supports($annotation)
    {
        return $annotation instanceof Query;
    }

    public function addValue(Request $request, $annotation, ParametersCollection $parameters)
    {
        $options = $request->getRequestOptions();
        $queryParams = [];
        if (isset($options[RequestOptions::QUERY])) {
            $queryParams = $options[RequestOptions::QUERY];
        }
        $value = $parameters->get($annotation->name);
        $queryParams = array_merge($queryParams, [$annotation->name => $value]);
        $request->setRequestOption(RequestOptions::QUERY, $queryParams);
    }
}