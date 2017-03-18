<?php

namespace Cos\RestClientBundle\Tests\Endpoint;


use Cos\RestClientBundle\Annotation\Endpoint;
use Cos\RestClientBundle\Annotation\Query;
use Cos\RestClientBundle\Endpoint\EndpointFactory;
use PHPUnit\Framework\TestCase;

class EndpointFactoryTest extends TestCase
{
    /**
     * @var EndpointFactory
     */
    private $factory;
    private $baseUri = 'http://test.com';

    protected function setUp()
    {
        $this->factory = new EndpointFactory();
    }

    public function testCreate()
    {
        $annotations = [
            new Endpoint([
                'uri' => '/posts',
                'method' => 'get']
            ),
            new Query()
        ];
        $endpoint = $this->factory->create($this->baseUri, $annotations);

        $this->assertEquals("http://test.com/posts", $endpoint->getUri());
        $this->assertCount(2, $endpoint->getAnnotations());
    }

    /**
     * @expectedException Cos\RestClientBundle\Exception\InvalidConfigurationException
     */
    public function testCreateWithoutEndpointAnnotation()
    {
        $this->factory->create($this->baseUri, []);
    }
}