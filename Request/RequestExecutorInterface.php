<?php

namespace Cos\RestClientBundle\Request;


interface RequestExecutorInterface
{
    public function execute(Request $request);
}