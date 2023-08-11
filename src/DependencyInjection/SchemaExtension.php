<?php

namespace SchemaBundle\DependencyInjection;

use SchemaBundle\EventListener\SchemaListener;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

class SchemaExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator([__DIR__ . '/../../config']));
        $loader->load('services.yaml');
    }

    public function prepend(ContainerBuilder $container): void
    {
        if (!$container->hasExtension('seo')) {
            return;
        }

        $loader = new YamlFileLoader($container, new FileLocator([__DIR__ . '/../../config']));

        $container->setParameter('schema.third_party.seo.enabled', true);
        $loader->load('third_party/seo.yaml');
    }
}
