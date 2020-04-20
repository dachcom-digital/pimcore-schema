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
     * {@inheritDoc}
     */
    public function boot()
    {
        $this->graph = new Graph();
    }

    /**
     * {@inheritDoc}
     */
    public function getTaskArguments(): array
    {
        return [$this->graph];
    }

    /**
     * {@inheritDoc}
     */
    public function onFinish(SeoMetaDataInterface $seoMetadata)
    {
        if (count($this->graph->getProperties()) > 0) {
            $seoMetadata->addSchema($this->graph->toArray());
        }
    }
}
