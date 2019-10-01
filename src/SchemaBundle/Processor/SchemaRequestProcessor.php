<?php

namespace SchemaBundle\Processor;

use Pimcore\Templating\Helper\HeadMeta;
use SchemaBundle\Registry\SchemaGeneratorRegistryInterface;
use Spatie\SchemaOrg\BaseType;
use Spatie\SchemaOrg\Graph;
use Symfony\Component\HttpFoundation\Request;

class SchemaRequestProcessor implements SchemaRequestProcessorInterface
{
    /**
     * @var HeadMeta
     */
    protected $headMeta;

    /**
     * @var SchemaGeneratorRegistryInterface
     */
    protected $generatorRegistry;

    /**
     * @param HeadMeta                         $headMeta
     * @param SchemaGeneratorRegistryInterface $generatorRegistry
     */
    public function __construct(
        HeadMeta $headMeta,
        SchemaGeneratorRegistryInterface $generatorRegistry
    ) {
        $this->headMeta = $headMeta;
        $this->generatorRegistry = $generatorRegistry;
    }

    /**
     * {@inheritdoc}
     */
    public function process(Request $request): void
    {
        $graph = new Graph();

        $schemaBlocks = [];

        foreach ($this->generatorRegistry->all() as $generator) {
            if ($generator->supportsRequest($request, $request->attributes->get('_route')) === false) {
                continue;
            }

            $generator->generateForRequest($graph, $request, $schemaBlocks);
        }

        $this->appendHeadMeta($graph, $schemaBlocks);
    }

    /**
     * @param Graph $graph
     * @param array $schemaBlocks
     */
    protected function appendHeadMeta(Graph $graph, array $schemaBlocks)
    {
        if (count($graph->getProperties()) > 0) {
            $this->headMeta->addRaw($graph->toScript());
        }

        foreach ($schemaBlocks as $schemaBlock) {
            if ($schemaBlock instanceof BaseType) {
                $this->headMeta->addRaw($schemaBlock);
            }
        }
    }
}
