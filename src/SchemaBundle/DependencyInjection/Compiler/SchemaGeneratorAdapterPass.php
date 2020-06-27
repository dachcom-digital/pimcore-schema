<?php

namespace SchemaBundle\DependencyInjection\Compiler;

use SchemaBundle\Registry\SchemaGeneratorRegistry;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class SchemaGeneratorAdapterPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        foreach ($container->findTaggedServiceIds('schema.generator', true) as $id => $tags) {
            $definition = $container->getDefinition(SchemaGeneratorRegistry::class);

            if ($container->getParameter('schema.flag.schema_listener_removed') === true) {
                $message = sprintf(
                    'Cannot register schema generator "%s" because you have installed the SEO Bundle. If you want to add some fragment generator (via twig) use the "schema.fragment_generator" tag. Read more about it here: %s',
                    $id,
                    'https://github.com/dachcom-digital/pimcore-schema/blob/master/docs/00_Usage.md'
                );

                throw new InvalidConfigurationException($message);
            }

            foreach ($tags as $attributes) {
                $definition->addMethodCall('registerGenerator', [new Reference($id), $attributes['alias']]);
            }
        }

        foreach ($container->findTaggedServiceIds('schema.fragment_generator', true) as $id => $tags) {
            $definition = $container->getDefinition(SchemaGeneratorRegistry::class);
            foreach ($tags as $attributes) {
                $definition->addMethodCall('registerFragmentGenerator', [new Reference($id), $attributes['alias']]);
            }
        }
    }
}
