<?php

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
