<?php

namespace Cos\RestClientBundle\Request;


use Cos\RestClientBundle\Event\Events;
use Cos\RestClientBundle\Event\RequestEvent;
use Cos\RestClientBundle\Event\ResponseEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class TraceableRequestExecutor implements RequestExecutorInterface
{
    private $requestExecutor;
    private $eventDispatcher;

    public function __construct(RequestExecutorInterface $requestExecutor, EventDispatcherInterface $eventDispatcher)
    {
        $this->requestExecutor = $requestExecutor;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(Request $request)
    {
        $requestEvent = new RequestEvent($request);
        $this->eventDispatcher->dispatch(Events::REST_REQUEST, $requestEvent);

        return $this->doExecute($request);
    }

    private function doExecute(Request $request)
    {
        $response = $this->requestExecutor->execute($request);
        $responseEvent = new ResponseEvent($response);
        $this->eventDispatcher->dispatch(Events::REST_RESPONSE, $responseEvent);

        return $response;
    }
}