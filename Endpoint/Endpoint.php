<?php

namespace Cos\RestClientBundle\Endpoint;


class Endpoint
{
    private $paths = array();

    private $uri;

    private $httpMethod;

    private $queryParams;

    private $requestBody;

    private $queryMap;

    private $json;

    private $multipart;

    private $form;

    public function __construct($uri, $method = 'get')
    {
        $this->uri = $uri;
        $this->httpMethod = $method;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getQueryMap()
    {
        return $this->queryMap;
    }

    public function getPath($name)
    {
        return $this->paths[$name];
    }

    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    public function getQueryParams()
    {
        return $this->queryParams;
    }

    public function getRequestBody()
    {
        return $this->requestBody;
    }

    public function setQueryMap($queryMap)
    {
        $this->queryMap = $queryMap;
    }

    public function addPath($path, $paramName)
    {
        $this->paths[$path] = $paramName;
    }

    public function addQueryParam($queryParam)
    {
        $this->queryParams[] = $queryParam;
    }

    public function setRequestBody($requestBody)
    {
        $this->requestBody = $requestBody;
    }

    public function setForm($form)
    {
        $this->form = $form;
    }

    public function getForm()
    {
        return $this->form;
    }

    public function getJson()
    {
        return $this->json;
    }

    public function setJson($json)
    {
        $this->json = $json;
    }

    public function getMultipart()
    {
        return $this->multipart;
    }

    public function setMultipart($multipart)
    {
        $this->multipart = $multipart;
    }
}