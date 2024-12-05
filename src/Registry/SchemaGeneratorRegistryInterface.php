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
