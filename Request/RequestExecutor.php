<?php

namespace Cos\RestClientBundle\Request;


use GuzzleHttp\ClientInterface;

class RequestExecutor
{
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function execute(Request $request)
    {

        $response = $this->client->request($request->getMethod(), $request->getUri(), $request->getRequestOptions());

        return $response;
    }
}