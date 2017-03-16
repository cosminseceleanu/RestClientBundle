<?php

namespace Cos\RestClientBundle\Request;


use Cos\RestClientBundle\Endpoint\Endpoint;
use Cos\RestClientBundle\Exception\InvalidTypeException;
use GuzzleHttp\RequestOptions;

class RequestBuilder
{
    /**
     * @var Endpoint
     */
    private $endpoint = null;

    private $parameters = array();

    public function setEndpoint(Endpoint $endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    public function build()
    {
        $uri = $this->getCompiledUri();
        $request = new Request($uri, $this->endpoint->getHttpMethod());
        $this->addQueryMap($request);
        $this->addQueryParams($request);
        $this->addRequestBody($request);
        $this->addMultipart($request);
        $this->addForm($request);
        $this->addJson($request);

        return $request;
    }

    private function getCompiledUri()
    {
        $uri = preg_replace_callback('/{(.*?)}/', function ($matches) {
            $paramName = $this->endpoint->getPath($matches[1]);

            return $this->parameters[$paramName];
        }, $this->endpoint->getUri());

        return $uri;
    }

    private function addQueryMap(Request $request)
    {
        if (empty($this->endpoint->getQueryMap())) {
            return;
        }
        $queryMapValue = $this->parameters[$this->endpoint->getQueryMap()];
        $this->validateArray($queryMapValue);
        $request->setRequestOption(RequestOptions::QUERY, $queryMapValue);
    }

    private function addQueryParams(Request $request)
    {
        if (empty($this->endpoint->getQueryParams())) {
            return;
        }
        $queryParams = [];
        foreach ($this->endpoint->getQueryParams() as $param) {
            $queryParams[$param] = $this->parameters[$param];
        }
        $request->setRequestOption(RequestOptions::QUERY, $queryParams);
    }

    private function addRequestBody(Request $request)
    {
        if ($this->endpoint->getRequestBody() !== null) {
            $request->setRequestOption(RequestOptions::BODY, $this->endpoint->getRequestBody());
        }
    }

    private function addMultipart(Request $request)
    {
        if (empty($this->endpoint->getMultipart())) {
            return;
        }
        $value = $this->parameters[$this->endpoint->getMultipart()];
        $this->validateArray($value);
        $request->setRequestOption(RequestOptions::MULTIPART, $value);
    }

    private function addForm(Request $request)
    {
        if (empty($this->endpoint->getForm())) {
            return;
        }

        $value = $this->parameters[$this->endpoint->getForm()];
        $this->validateArray($value);
        $request->setRequestOption(RequestOptions::FORM_PARAMS, $value);
    }

    private function addJson(Request $request)
    {
        if (!empty($this->endpoint->getJson())) {
            $request->setRequestOption(RequestOptions::JSON, $this->parameters[$this->endpoint->getJson()]);
        }
    }

    private function validateArray($value)
    {
        if (is_array($value)) {
            return;
        }

        throw new InvalidTypeException(gettype(array()), gettype($value));
    }
}