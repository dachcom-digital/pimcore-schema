<?php

namespace SchemaBundle\Seo\Middleware;

use SeoBundle\Middleware\MiddlewareAdapterInterface;
use SeoBundle\Model\SeoMetaDataInterface;
use Spatie\SchemaOrg\Graph;

class SchemaGraphAdapter implements MiddlewareAdapterInterface
{
    protected Graph $graph;

    public function boot(): void
    {
        $this->graph = new Graph();
    }

    public function getTaskArguments(): array
    {
        return [$this->graph];
    }

    public function onFinish(SeoMetaDataInterface $seoMetadata): void
    {
        $nodes = $this->graph->getNodes();

        if (count($nodes) > 0) {
            $seoMetadata->addSchema($this->graph->toArray());
        }
    }
}
