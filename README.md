# Pimcore Schema
Schema.org type builder and ld+json generator for pimcore. This bundle requires the `spatie/schema-org` package. 

#### Requirements
* Pimcore >= 6.0.0

## Installation

```json
"require" : {
    "dachcom-digital/schema" : "~1.0.0",
}
```

## Bootstrap
The Schema Bundles allows you to build schema blocks in two sections:

- based on request: add ld+json data to head based on request
- based on element: add ld+json data to your markup by using the `json_ld` twig helper based on given element

## Simple Usage

```twig
    AppBundle\Schema\Generator\KnowledgeGraphGenerator:
        autowire: true
        tags:
            - {name: schema.generator, alias: knowledge_graph }
```

### Service

```php
<?php

namespace AppBundle\Schema\Generator;

use SchemaBundle\Generator\GeneratorInterface;
use Spatie\SchemaOrg\BaseType;
use Spatie\SchemaOrg\Graph;
use Symfony\Component\HttpFoundation\Request;

class KnowledgeGraphGenerator implements GeneratorInterface
{
    /**
     * {@inheritDoc}
     */
    public function supportsRequest(Request $request, string $route): bool
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function supportsElement($element): bool
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function generateForRequest(Graph $graph, Request $request, array &$schemaBlocks): void
    {
        // just a dummy.
        // you could use the pimcore website settings for example

        $myBusiness = [
            'name'  => 'My Business Name',
            'email' => 'info@mybusiness.com'
        ];

        $graph
            ->organization()
                ->name($myBusiness['name']);
    }

    /**
     * {@inheritDoc}
     */
    public function generateForElement($element): ?BaseType
    {
        return null;
    }
}
```
