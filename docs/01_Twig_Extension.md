# Render json-ld data directly in twig templates
You're able to render json-ld data in your markup. For this you need to make use of the `json_ld` twig extension.

## Register Service

```yml
AppBundle\Schema\Generator\ProductGenerator:
    autowire: true
    tags:
        - {name: schema.generator, alias: product }
```

## Build Service

```php
<?php

namespace AppBundle\Schema\Generator;

use Pimcore\Model\DataObject\TestClass;
use SchemaBundle\Generator\GeneratorInterface;
use Spatie\SchemaOrg\BaseType;
use Spatie\SchemaOrg\Graph;
use Spatie\SchemaOrg\Schema;
use Symfony\Component\HttpFoundation\Request;

class ProductGenerator implements GeneratorInterface
{
    /**
     * {@inheritDoc}
     */
    public function supportsRequest(Request $request, string $route): bool
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function supportsElement($element): bool
    {
        return $element instanceof TestClass;
    }

    /**
     * {@inheritDoc}
     */
    public function generateForRequest(Graph $graph, Request $request, array &$schemaBlocks): void
    {
        // nothing to do since we do not support requests
    }

    /**
     * {@inheritDoc}
     */
    public function generateForElement($element): ?BaseType
    {
        /** @var TestClass $product */
        $product = $element;

        return Schema::product()
            ->name($product->getName())
            ->sku($product->getSku());
    }
}
```

### Add Filter to Object

```twig
<div class="container">
    <h3>json ld for object</h3>
    {% set object = pimcore_object(41) %}
    {{ object|json_ld }}
</div>
```