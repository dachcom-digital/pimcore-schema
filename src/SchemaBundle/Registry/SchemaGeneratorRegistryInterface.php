<?php

namespace SchemaBundle\Registry;

use SchemaBundle\Generator\GeneratorInterface;

interface SchemaGeneratorRegistryInterface
{
    /**
     * @param GeneratorInterface $service
     * @param string             $alias
     */
    public function register($service, $alias);

    /**
     * @param string $alias
     *
     * @return bool
     */
    public function has($alias);

    /**
     * @return array|GeneratorInterface[]
     */
    public function all();

    /**
     * @param string $alias
     *
     * @return GeneratorInterface
     *
     * @throws \Exception
     */
    public function get($alias);
}
