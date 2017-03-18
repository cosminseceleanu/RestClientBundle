<?php

namespace Cos\RestClientBundle\Tests\Fixtures;

use Cos\RestClientBundle\Annotation\Client;
use Cos\RestClientBundle\Annotation\Endpoint;
use Cos\RestClientBundle\Annotation\Path;

/**
 * @Client(name="default")
 */
interface MockApi
{
    /**
     * @Path(name="id", paramName="id")
     * @Endpoint(uri="/foo/{id}")
     */
    public function get($id);
}