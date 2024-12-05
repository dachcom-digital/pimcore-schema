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
