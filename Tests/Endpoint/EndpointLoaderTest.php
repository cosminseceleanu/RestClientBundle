<?php

namespace Cos\RestClientBundle\Tests\Endpoint;


use Cos\RestClientBundle\Annotation\Client;
use Cos\RestClientBundle\Annotation\Endpoint as EndpointAnnotation;
use Cos\RestClientBundle\Endpoint\Endpoint;
use Cos\RestClientBundle\Endpoint\EndpointCollection;
use Cos\RestClientBundle\Endpoint\EndpointFactory;
use Cos\RestClientBundle\Endpoint\EndpointLoader;
use Cos\RestClientBundle\Tests\Fixtures\MockApi;
use Doctrine\Common\Annotations\Reader;
use PHPUnit\Framework\TestCase;

class EndpointLoaderTest extends TestCase
{
    private $clients = [
        'default' => ['baseUri' => 'http://test.com']
    ];

    /** @var EndpointLoader */
    private $loader;

    private $endpoint;

    private $methodAnnotations;

    private $classAnnotations;

    protected function setUp()
    {
        $this->endpoint = new Endpoint('http://test.com');
        $endpoint = new EndpointAnnotation(['uri' => '/foo']);
        $this->methodAnnotations = [$endpoint];
        $client = new Client();
        $client->name = 'default';
        $this->classAnnotations = [$client];
    }

    public function testLoad()
    {
        $loader = new EndpointLoader(
            $this->getReaderMock($this->classAnnotations),
            $this->getEndpointCollectionMock(),
            $this->getEndpointFactoryMock(),
            $this->clients
        );

        $loader->load(MockApi::class);

        \Mockery::close();
    }

    /**
     * @expectedException Cos\RestClientBundle\Exception\InvalidConfigurationException
     */
    public function testLoadWithoutClient()
    {
        $loader = new EndpointLoader(
            $this->getReaderMock(),
            $this->getEndpointCollectionMock(0),
            $this->getEndpointFactoryMock(0),
            $this->clients
        );
        $loader->load(MockApi::class);
        \Mockery::close();
    }

    /**
     * @expectedException Cos\RestClientBundle\Exception\ParameterNotSetException
     */
    public function testLoadWithWrongClient()
    {
        $loader = new EndpointLoader(
            $this->getReaderMock($this->classAnnotations),
            $this->getEndpointCollectionMock(0),
            $this->getEndpointFactoryMock(0),
            []
        );
        $loader->load(MockApi::class);
        \Mockery::close();
    }


    private function getReaderMock(array $returnedAnnotations = array())
    {
        return \Mockery::mock(Reader::class)
            ->shouldReceive('getClassAnnotations')
            ->withAnyArgs()
            ->andReturn($returnedAnnotations)
            ->getMock()
            ->shouldReceive('getMethodAnnotations')
            ->withAnyArgs()
            ->andReturn($this->methodAnnotations)
            ->getMock();
    }

    private function getEndpointCollectionMock($limit = 1)
    {
        return \Mockery::mock(EndpointCollection::class)
            ->shouldReceive('add')
            ->with(MockApi::class, 'get', $this->endpoint)
            ->times($limit)
            ->andReturnNull()
            ->getMock()
            ->shouldReceive('has')
            ->withAnyArgs()
            ->andReturn(false)
            ->getMock();
    }

    private function getEndpointFactoryMock($limit = 1)
    {
        return \Mockery::mock(EndpointFactory::class)
            ->shouldReceive('create')
            ->with('http://test.com', $this->methodAnnotations)
            ->times($limit)
            ->andReturn($this->endpoint)
            ->getMock();
    }
}