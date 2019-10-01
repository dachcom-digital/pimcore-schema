<?php

namespace SchemaBundle\Processor;

use SchemaBundle\Registry\SchemaGeneratorRegistryInterface;
use Spatie\SchemaOrg\BaseType;

class SchemaElementProcessor implements SchemaElementProcessorInterface
{
    /**
     * @var SchemaGeneratorRegistryInterface
     */
    protected $generatorRegistry;

    /**
     * @param SchemaGeneratorRegistryInterface $generatorRegistry
     */
    public function __construct(
        SchemaGeneratorRegistryInterface $generatorRegistry
    ) {
        $this->generatorRegistry = $generatorRegistry;
    }

    /**
     * {@inheritdoc}
     */
    public function process($element): string
    {
        $data = null;
        foreach ($this->generatorRegistry->all() as $generator) {
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
