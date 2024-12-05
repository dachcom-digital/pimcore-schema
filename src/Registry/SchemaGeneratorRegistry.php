<?php

/*
 * This source file is available under two different licenses:
 *   - GNU General Public License version 3 (GPLv3)
 *   - DACHCOM Commercial License (DCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) DACHCOM.DIGITAL AG (https://www.dachcom-digital.com)
 * @license    GPLv3 and DCL
 */

namespace SchemaBundle\Registry;

use SchemaBundle\Generator\FragmentGeneratorInterface;
use SchemaBundle\Generator\GeneratorInterface;

class SchemaGeneratorRegistry implements SchemaGeneratorRegistryInterface
{
    protected array $generator = [];
    protected array $fragmentGenerator = [];
    protected string $generatorInterface;
    protected string $fragmentGeneratorInterface;

    public function __construct(string $generatorInterface, string $fragmentGeneratorInterface)
    {
        $this->generatorInterface = $generatorInterface;
        $this->fragmentGeneratorInterface = $fragmentGeneratorInterface;
    }

    public function registerGenerator(mixed $service, string $alias): void
    {
        if (!in_array($this->generatorInterface, class_implements($service), true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    '%s needs to implement "%s", "%s" given.',
                    get_class($service),
                    $this->generatorInterface,
                    implode(', ', class_implements($service))
                )
            );
        }

        $this->generator[$alias] = $service;
    }

    public function registerFragmentGenerator(mixed $service, string $alias): void
    {
        if (!in_array($this->fragmentGeneratorInterface, class_implements($service), true)) {
            throw new \InvalidArgumentException(
                sprintf(
                    '%s needs to implement "%s", "%s" given.',
                    get_class($service),
                    $this->fragmentGeneratorInterface,
                    implode(', ', class_implements($service))
                )
            );
        }

        $this->fragmentGenerator[$alias] = $service;
    }

    public function hasGenerator(string $alias): bool
    {
        return isset($this->generator[$alias]);
    }

    public function hasFragmentGenerator(string $alias): bool
    {
        return isset($this->fragmentGenerator[$alias]);
    }

    public function allGenerators(): array
    {
        return $this->generator;
    }

    public function allFragmentGenerators(): array
    {
        return $this->fragmentGenerator;
    }

    public function getGenerator(string $alias): GeneratorInterface
    {
        if (!$this->hasGenerator($alias)) {
            throw new \Exception('"' . $alias . '" Schema Generator does not exist');
        }

        return $this->generator[$alias];
    }

    public function getFragmentGenerator(string $alias): FragmentGeneratorInterface
    {
        if (!$this->hasFragmentGenerator($alias)) {
            throw new \Exception('"' . $alias . '" Schema Fragment Generator does not exist');
        }

        return $this->fragmentGenerator[$alias];
    }
}
