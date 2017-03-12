<?php

namespace Cos\RestClientBundle\Request;


use Cos\RestClientBundle\Endpoint\Endpoint;
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
        if (!empty($this->endpoint->getQueryMap())) {
            $queryMapValue = $this->parameters[$this->endpoint->getQueryMap()];
            if (!is_array($queryMapValue)) {
                throw new \InvalidArgumentException("Query map must be of type array");
            }
            $request->setRequestOption(RequestOptions::QUERY, $queryMapValue);
        }
    }

    private function addQueryParams(Request $request)
    {
        if (!empty($this->endpoint->getQueryParams())) {
            $queryParams = [];
            foreach ($this->endpoint->getQueryParams() as $param) {
                $queryParams[$param] = $this->parameters[$param];
            }
            $request->setRequestOption(RequestOptions::QUERY, $queryParams);
        }
    }

    private function addRequestBody(Request $request)
    {
        if ($this->endpoint->getRequestBody() !== null) {
            $request->setRequestOption(RequestOptions::BODY, $this->endpoint->getRequestBody());
        }
    }
}