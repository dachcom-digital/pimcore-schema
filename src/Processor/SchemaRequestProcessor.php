<?php

namespace SchemaBundle\Processor;

use Pimcore\Twig\Extension\Templating\HeadMeta;
use SchemaBundle\Registry\SchemaGeneratorRegistryInterface;
use Spatie\SchemaOrg\BaseType;
use Spatie\SchemaOrg\Graph;
use Symfony\Component\HttpFoundation\Request;

class SchemaRequestProcessor implements SchemaRequestProcessorInterface
{
    public function __construct(
        protected HeadMeta $headMeta,
        protected SchemaGeneratorRegistryInterface $generatorRegistry
    ) {
    }

    public function process(Request $request): void
    {
        $graph = new Graph();

        $schemaBlocks = [];

        foreach ($this->generatorRegistry->allGenerators() as $generator) {
            if ($generator->supportsRequest($request, $request->attributes->get('_route')) === false) {
                continue;
            }

            $generator->generateForRequest($graph, $request, $schemaBlocks);
        }

        $this->appendHeadMeta($graph, $schemaBlocks);
    }

    protected function appendHeadMeta(Graph $graph, array $schemaBlocks): void
    {
        $nodes = $graph->getNodes();

        if (count($nodes) > 0) {
            $this->headMeta->addRaw($graph->toScript());
        }

        foreach ($schemaBlocks as $schemaBlock) {
            if ($schemaBlock instanceof BaseType) {
                $this->headMeta->addRaw($schemaBlock);
            }
        }
    }
}
