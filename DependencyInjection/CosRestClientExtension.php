<?php

namespace Cos\RestClientBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class CosRestClientExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $container->setParameter('cos_rest_client.clients', $config['clients']);
//        echo '<pre>';
//        print_r($config);
//        die('aaa');

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $this->setupAnnotationReader($config, $container);
    }

    private function setupAnnotationReader(array $config, ContainerBuilder $container)
    {
        if (empty($config['annotation_reader'])) {
            return;
        }

        $container->getDefinition('cos_rest_client.endpoint_loader')
            ->replaceArgument(0, new Reference($config['annotation_reader']));
    }
}
