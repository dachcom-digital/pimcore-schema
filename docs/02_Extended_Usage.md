## Extended Usage

Use the `Graph` Element to join multiple services:

## Register Service

```yml
AppBundle\Schema\Generator\OrganizationGenerator:
    autowire: true
    tags:
        - {name: schema.generator, alias: organization }

AppBundle\Schema\Generator\ProductGenerator:
    autowire: true
    tags:
        - {name: schema.generator, alias: product }
```

## Build Services

#### OrganizationGenerator

```php
<?php

namespace AppBundle\Schema\Generator;

use SchemaBundle\Generator\GeneratorInterface;
use Spatie\SchemaOrg\BaseType;
use Spatie\SchemaOrg\Graph;
use Symfony\Component\HttpFoundation\Request;

class OrganizationGenerator implements GeneratorInterface
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
        $graph
            ->organization()
                ->name('My awesome Company');
    }

    /**
     * {@inheritDoc}
     */
    public function generateForElement($element): ?BaseType
    {
        // return null since we do not support requests
        return null;
    }
}
```


#### ProductGenerator

```php
<?php

namespace AppBundle\Schema\Generator;

use SchemaBundle\Generator\GeneratorInterface;
use Spatie\SchemaOrg\BaseType;
use Spatie\SchemaOrg\Graph;
use Symfony\Component\HttpFoundation\Request;

class ProductGenerator implements GeneratorInterface
{
    /**
     * {@inheritDoc}
     */
    public function supportsRequest(Request $request, string $route): bool
    {
        return $request->attributes->has('product-id');
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
        $graph
            ->product()
                ->name('My cool Product')
                ->brand($graph->organization());
    }

    /**
     * {@inheritDoc}
     */
    public function generateForElement($element): ?BaseType
    {
        // return null since we do not support requests
        return null;
    }
}
```