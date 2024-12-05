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
