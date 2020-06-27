<?php

namespace SchemaBundle\Seo\Middleware;

use SeoBundle\Middleware\MiddlewareAdapterInterface;
use SeoBundle\Model\SeoMetaDataInterface;
use Spatie\SchemaOrg\Graph;

class SchemaGraphAdapter implements MiddlewareAdapterInterface
{
    /**
     * @var Graph
     */
    protected $graph;

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $this->graph = new Graph();
    }

    /**
     * {@inheritdoc}
     */
    public function getTaskArguments(): array
    {
        return [$this->graph];
    }

    /**
     * {@inheritdoc}
     */
    public function onFinish(SeoMetaDataInterface $seoMetadata)
    {
        // spatie/schema-org changed getProperties to getNodes after 2.14
        $nodes = method_exists($this->graph, 'getProperties')
            ? $this->graph->getProperties()
            : $this->graph->getNodes();

        if (count($nodes) > 0) {
            $seoMetadata->addSchema($this->graph->toArray());
        }
    }
}
