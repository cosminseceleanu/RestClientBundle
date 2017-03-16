<?php

namespace Cos\RestClientBundle\Event;


use Cos\RestClientBundle\Request\Request;
use Symfony\Component\EventDispatcher\Event;

class RequestEvent extends Event
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getRequest()
    {
        return $this->request;
    }
}