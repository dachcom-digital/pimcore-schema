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

namespace SchemaBundle\Processor;

use SchemaBundle\Registry\SchemaGeneratorRegistryInterface;
use Spatie\SchemaOrg\BaseType;

class SchemaElementProcessor implements SchemaElementProcessorInterface
{
    public function __construct(protected SchemaGeneratorRegistryInterface $generatorRegistry)
    {
    }

    public function process($element): string
    {
        $data = null;
        foreach ($this->generatorRegistry->allGenerators() as $generator) {
            if ($generator->supportsElement($element) === true) {
                $data = $generator->generateForElement($element);

                break;
            }
        }

        if (!$data instanceof BaseType) {
            return '';
        }

        return $data->toScript();
    }

    public function processFragment($element): string
    {
        $data = null;
        foreach ($this->generatorRegistry->allFragmentGenerators() as $generator) {
            if ($generator->supportsElement($element) === true) {
                $data = $generator->generateForElement($element);

                break;
            }
        }

        if (!$data instanceof BaseType) {
            return '';
        }

        return $data->toScript();
    }
}
