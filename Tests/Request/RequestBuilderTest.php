<?php

namespace Cos\RestClientBundle\Tests\Request;


use Cos\RestClientBundle\Annotation\Path;
use Cos\RestClientBundle\Annotation\Query;
use Cos\RestClientBundle\Endpoint\Endpoint;
use Cos\RestClientBundle\Request\Options\RequestOptionInterface;
use Cos\RestClientBundle\Request\Options\RequestOptionsCollection;
use Cos\RestClientBundle\Request\RequestBuilder;
use PHPUnit\Framework\TestCase;

class RequestBuilderTest extends TestCase
{
    private $parameters = [
        'id' => 1
    ];

    private $path;

    /**
     * @var RequestBuilder
     */
    private $builder;

    protected function setUp()
    {
        $this->path = new Path();
        $this->path->name = 'url_id';
        $this->path->paramName = 'id';
        $this->builder = new RequestBuilder($this->getRequestOptionsMock());
    }

    public function testBuild()
    {
        $endpoint = new Endpoint('http://test.com/foo', 'post');
        $request = $this->builder->setEndpoint($endpoint)
            ->build();

        $this->assertEquals("http://test.com/foo", $request->getUri());
        $this->assertEquals("post", $request->getMethod());
    }

    public function testBuildWithPathInUri()
    {

        $endpoint = new Endpoint('http://test.com/foo/{url_id}', 'get', [$this->path]);
        $request = $this->builder->setEndpoint($endpoint)
            ->setParameters($this->parameters)
            ->build();

        $this->assertEquals('http://test.com/foo/1', $request->getUri());
    }

    /**
     * @expectedException Cos\RestClientBundle\Exception\InvalidConfigurationException
     */
    public function testBuildWithWrongPathInUri()
    {
        $endpoint = new Endpoint('http://test.com/foo/{id}', 'get', [$this->path]);
        $request = $this->builder->setEndpoint($endpoint)
            ->setParameters($this->parameters)
            ->build();

        $this->assertEquals('http://test.com/foo/1', $request->getUri());
    }

    /**
     * @expectedException Cos\RestClientBundle\Exception\ParameterNotSetException
     */
    public function testBuildWithWrongParamForPath()
    {
        $this->path->paramName = 'wrongId';
        $endpoint = new Endpoint('http://test.com/foo/{url_id}', 'get', [$this->path]);
        $request = $this->builder->setEndpoint($endpoint)
            ->setParameters($this->parameters)
            ->build();

        $this->assertEquals('http://test.com/foo/1', $request->getUri());
    }

    public function testWithRequestOptions()
    {
        $requestOption = \Mockery::mock(RequestOptionInterface::class)
            ->shouldReceive('supports')
            ->withAnyArgs()
            ->andReturn(true)
            ->getMock()
            ->shouldReceive('addValue')
            ->withAnyArgs()
            ->once()
            ->getMock();
        $query = new Query();
        $query->name = 'id';
        $endpoint = new Endpoint('uri', 'get', [$query]);
        $builder = new RequestBuilder($this->getRequestOptionsMock([$requestOption]));
        $builder->setParameters($this->parameters)
            ->setEndpoint($endpoint)
            ->build();
        \Mockery::close();
    }

    private function getRequestOptionsMock(array $options = [])
    {
        return \Mockery::mock(RequestOptionsCollection::class)
            ->shouldReceive('getOptions')
            ->withNoArgs()
            ->andReturn($options)
            ->getMock();
    }
}