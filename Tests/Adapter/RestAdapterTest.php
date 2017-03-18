<?php

namespace Cos\RestClientBundle\Tests\Adapter;


use Cos\RestClientBundle\Adapter\RestAdapter;
use Cos\RestClientBundle\Endpoint\Endpoint;
use Cos\RestClientBundle\Endpoint\EndpointCollection;
use Cos\RestClientBundle\Request\Request;
use Cos\RestClientBundle\Request\RequestBuilder;
use Cos\RestClientBundle\Request\RequestExecutorInterface;
use Cos\RestClientBundle\Tests\Fixtures\MockApi;
use PHPUnit\Framework\TestCase;

class RestAdapterTest extends TestCase
{
    private $endpoint;
    private $parameters = [
        'id' => 1
    ];
    private $request;

    protected function setUp()
    {
        $uri = 'http://test/com';
        $this->endpoint = new Endpoint($uri);
        $this->request = new Request($uri, 'get');
    }

    public function testCall()
    {
        $adapter = new RestAdapter(
            $this->getRequestExecutorMock(),
            $this->getEndpointCollectionMock(),
            $this->getRequestBuilderMock()
        );
        $adapter->call(MockApi::class, 'get', [0 => 1]);
        \Mockery::close();
    }

    private function getRequestExecutorMock()
    {
        return \Mockery::mock(RequestExecutorInterface::class)
            ->shouldReceive('execute')
            ->withAnyArgs()
            ->once()
            ->andReturnNull()
            ->getMock();
    }

    private function getEndpointCollectionMock()
    {
        return \Mockery::mock(EndpointCollection::class)
            ->shouldReceive('get')
            ->with(MockApi::class, 'get')
            ->once()
            ->andReturn($this->endpoint)
            ->getMock();
    }

    private function getRequestBuilderMock()
    {
        $mock = \Mockery::mock(RequestBuilder::class);

        $mock->shouldReceive('setEndpoint')
            ->with($this->endpoint)
            ->andReturn($mock)
            ->getMock();

        $mock->shouldReceive('setParameters')
            ->with($this->parameters)
            ->andReturn($mock)
            ->getMock();

        return $mock->shouldReceive('build')
            ->withNoArgs()
            ->andReturn($this->request)
            ->getMock();
    }
}