<?php

namespace Cos\RestClientBundle\DependencyInjection\Compiler;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RequestOptionsPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $requestOptions = $container->getDefinition('cos_rest_client.request_options');
        $taggedOptions = $container->findTaggedServiceIds('cos_rest.request_option');
        foreach ($taggedOptions as $id => $tags) {
            $requestOptions->addMethodCall('register', [new Reference($id)]);
        }
    }
}