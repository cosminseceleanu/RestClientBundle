<?php

namespace Cos\RestClientBundle\Request;


use Cos\RestClientBundle\Endpoint\Endpoint;
use Cos\RestClientBundle\Request\Options\RequestOptionsCollection;

class RequestBuilder
{
    /**
     * @var Endpoint
     */
    private $endpoint = null;

    /**
     * @var ParametersCollection
     */
    private $parameters;

    private $requestOptions;

    public function __construct(RequestOptionsCollection $requestOptions)
    {
        $this->requestOptions = $requestOptions;
    }

    public function setEndpoint(Endpoint $endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    public function setParameters(array $parameters)
    {
        $this->parameters = new ParametersCollection($parameters);

        return $this;
    }

    public function build()
    {
        $uri = $this->getCompiledUri();
        $request = new Request($uri, $this->endpoint->getHttpMethod());
        $this->parseAnnotations($request);

        return $request;
    }

    private function getCompiledUri()
    {
        $uri = preg_replace_callback('/{(.*?)}/', function ($matches) {
            $path = $this->endpoint->getPath($matches[1]);

            return $this->parameters->get($path->paramName);
        }, $this->endpoint->getUri());

        return $uri;
    }

    private function parseAnnotations(Request $request)
    {
        foreach ($this->endpoint->getAnnotations() as $annotation) {
            foreach ($this->requestOptions->getOptions() as $option) {
                if (!$option->supports($annotation)) {
                    continue;
                }
                $option->addValue($request, $annotation, $this->parameters);
            }
        }
    }
}