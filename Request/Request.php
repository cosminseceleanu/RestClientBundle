<?php

namespace Cos\RestClientBundle\Request;


class Request
{
    private $uri;
    private $method;
    private $requestOptions = array();

    public function __construct($uri, $method)
    {
        $this->uri = $uri;
        $this->method = $method;
    }

    public function setRequestOption($option, $value)
    {
        $this->requestOptions[$option] = $value;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getRequestOptions()
    {
        return $this->requestOptions;
    }
}