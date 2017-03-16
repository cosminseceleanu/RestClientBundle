<?php

namespace Cos\RestClientBundle\Event;


use Psr\Http\Message\ResponseInterface;
use Symfony\Component\EventDispatcher\Event;

class ResponseEvent extends Event
{
    private $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function getResponse()
    {
        return $this->response;
    }
}