<?php

namespace SchemaBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;
use Pimcore\Extension\Bundle\Traits\PackageVersionTrait;
use SchemaBundle\DependencyInjection\Compiler\SchemaGeneratorAdapterPass;
use SchemaBundle\Tool\Install;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SchemaBundle extends AbstractPimcoreBundle
{
    use PackageVersionTrait;

    public const PACKAGE_NAME = 'dachcom-digital/schema';

    public function getInstaller(): Install
    {
        return $this->container->get(Install::class);
    }

    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new SchemaGeneratorAdapterPass());
    }

    protected function getComposerPackageName(): string
    {
        return self::PACKAGE_NAME;
    }
}
