<?php

namespace SchemaBundle\DependencyInjection;

use SchemaBundle\EventListener\SchemaListener;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

class SchemaExtension extends Extension
{
    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     *
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator([__DIR__ . '/../Resources/config']));
        $loader->load('services.yml');

        $this->checkDependencies($container, $loader);
    }

    /**
     * @param ContainerBuilder $container
     * @param YamlFileLoader   $loader
     *
     * @throws \Exception
     */
    protected function checkDependencies(ContainerBuilder $container, YamlFileLoader $loader)
    {
        $bundles = $container->getParameter('kernel.bundles');
        $container->setParameter('schema.flag.schema_listener_removed', false);

        if (array_key_exists('SeoBundle', $bundles)) {
            $loader->load('external/seo.yml');
            if ($container->hasDefinition(SchemaListener::class)) {
                $container->removeDefinition(SchemaListener::class);
                $container->setParameter('schema.flag.schema_listener_removed', true);
            }
        }
    }
}
