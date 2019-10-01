<?php

namespace SchemaBundle\DependencyInjection\Compiler;

use SchemaBundle\Registry\SchemaGeneratorRegistry;
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
            foreach ($tags as $attributes) {
                $definition->addMethodCall('register', [new Reference($id), $attributes['alias']]);
            }
        }
    }
}
