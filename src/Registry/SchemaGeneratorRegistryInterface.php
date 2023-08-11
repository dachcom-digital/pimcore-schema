<?php

namespace SchemaBundle\Registry;

use SchemaBundle\Generator\FragmentGeneratorInterface;
use SchemaBundle\Generator\GeneratorInterface;

interface SchemaGeneratorRegistryInterface
{
    public function registerGenerator(mixed $service, string $alias): void;

    public function registerFragmentGenerator(mixed $service, string $alias): void;

    public function hasGenerator(string $alias): bool;

    public function hasFragmentGenerator(string $alias): bool;

    /**
     * @return array<int, GeneratorInterface>
     */
    public function allGenerators(): array;

    /**
     * @return array<int, FragmentGeneratorInterface>
     */
    public function allFragmentGenerators(): array;

    /**
     * @throws \Exception
     */
    public function getGenerator(string $alias): GeneratorInterface;

    /**
     * @throws \Exception
     */
    public function getFragmentGenerator(string $alias): FragmentGeneratorInterface;
}
