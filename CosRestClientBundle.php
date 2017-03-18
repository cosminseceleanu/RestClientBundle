<?php

namespace Cos\RestClientBundle;

use Cos\RestClientBundle\DependencyInjection\Compiler\RequestOptionsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CosRestClientBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new RequestOptionsPass());
    }
}
