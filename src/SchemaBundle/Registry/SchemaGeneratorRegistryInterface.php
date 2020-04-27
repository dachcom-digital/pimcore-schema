<?php

namespace SchemaBundle\Registry;

use SchemaBundle\Generator\FragmentGeneratorInterface;
use SchemaBundle\Generator\GeneratorInterface;

interface SchemaGeneratorRegistryInterface
{
    /**
     * @param GeneratorInterface $service
     * @param string             $alias
     */
    public function registerGenerator($service, $alias);

    /**
     * @param FragmentGeneratorInterface $service
     * @param string                     $alias
     */
    public function registerFragmentGenerator($service, $alias);

    /**
     * @param string $alias
     *
     * @return bool
     */
    public function hasGenerator($alias);

    /**
     * @param string $alias
     *
     * @return bool
     */
    public function hasFragmentGenerator($alias);

    /**
     * @return array|GeneratorInterface[]
     */
    public function allGenerators();

    /**
     * @return array|FragmentGeneratorInterface[]
     */
    public function allFragmentGenerators();

    /**
     * @param string $alias
     *
     * @return GeneratorInterface
     *
     * @throws \Exception
     */
    public function getGenerator($alias);

    /**
     * @param string $alias
     *
     * @return FragmentGeneratorInterface
     *
     * @throws \Exception
     */
    public function getFragmentGenerator($alias);
}
