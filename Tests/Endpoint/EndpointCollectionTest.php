<?php

namespace Cos\RestClientBundle\Tests\Endpoint;


use Cos\RestClientBundle\Endpoint\Endpoint;
use Cos\RestClientBundle\Endpoint\EndpointCollection;
use PHPUnit\Framework\TestCase;

class EndpointCollectionTest extends TestCase
{
    /**
     * @var EndpointCollection
     */
    private $endpointCollection;

    protected function setUp()
    {
        $this->endpointCollection = new EndpointCollection();
        $this->endpointCollection->add('class1', 'method1', $this->getEndpointMock());
        $this->endpointCollection->add('class1', 'method2', $this->getEndpointMock());
        $this->endpointCollection->add('class2', 'method1', $this->getEndpointMock());
    }

    public function testGet()
    {
        $this->assertNotNull($this->endpointCollection->get('class1', 'method1'));
        $this->assertNotNull($this->endpointCollection->get('class2', 'method1'));
    }

    /**
     * @expectedException Cos\RestClientBundle\Exception\InvalidConfigurationException
     */
    public function testNotFound()
    {
        $this->endpointCollection->get('class3', 'method1');
    }

    public function testHas()
    {
        $this->assertTrue($this->endpointCollection->has('class1'));
        $this->assertFalse($this->endpointCollection->has('class3'));
    }

    private function getEndpointMock()
    {
        return \Mockery::mock(Endpoint::class);
    }
}