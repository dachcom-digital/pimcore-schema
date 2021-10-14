# Standalone Usage

> **Note!!** This does not work if you have installed the [SEO Bundle](https://github.com/dachcom-digital/pimcore-seo)!
> Read more about it [here](./00_Usage.md)!

***

## Bootstrap
The Schema Bundles allows you to build schema blocks in two sections:

- based on request: add ld+json data to head based on request
- based on element: add ld+json data to your markup by using the `json_ld` twig helper based on given element

## I. Simple Usage Example

```yml
App\Schema\Generator\KnowledgeGraphGenerator:
    autowire: true
    tags:
        - { name: schema.generator, alias: knowledge_graph }
```

### Service

```php
<?php

namespace App\Schema\Generator;

use Spatie\SchemaOrg\Graph;
use Spatie\SchemaOrg\BaseType;
use Symfony\Component\HttpFoundation\Request;
use SchemaBundle\Generator\GeneratorInterface;

class KnowledgeGraphGenerator implements GeneratorInterface
{
    public function supportsRequest(Request $request, string $route): bool
    {
        return true;
    }

    public function supportsElement($element): bool
    {
        return false;
    }

    public function generateForRequest(Graph $graph, Request $request, array &$schemaBlocks): void
    {
        // just a dummy here
        // you could use the pimcore website settings for example

        $myBusiness = [
            'name'  => 'My Business Name',
            'email' => 'info@mybusiness.com'
        ];

        $graph
            ->organization()
                ->name($myBusiness['name']);
    }

    public function generateForElement($element): ?BaseType
    {
        return null;
    }
}
```

***

## II. Extended Usage Example

Use the `Graph` Element to join multiple services.

### Register Service

```yml
App\Schema\Generator\OrganizationGenerator:
    autowire: true
    tags:
        - { name: schema.generator, alias: organization }

App\Schema\Generator\ProductGenerator:
    autowire: true
    tags:
        - { name: schema.generator, alias: product }
```

### Build Services

#### OrganizationGenerator

```php
<?php

namespace App\Schema\Generator;

use SchemaBundle\Generator\GeneratorInterface;
use Spatie\SchemaOrg\BaseType;
use Spatie\SchemaOrg\Graph;
use Symfony\Component\HttpFoundation\Request;

class OrganizationGenerator implements GeneratorInterface
{
    public function supportsRequest(Request $request, string $route): bool
    {
        return true;
    }

    public function supportsElement($element): bool
    {
        return false;
    }

    public function generateForRequest(Graph $graph, Request $request, array &$schemaBlocks): void
    {
        $graph
            ->organization()
                ->name('My awesome Company');
    }

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

namespace App\Schema\Generator;

use SchemaBundle\Generator\GeneratorInterface;
use Spatie\SchemaOrg\BaseType;
use Spatie\SchemaOrg\Graph;
use Symfony\Component\HttpFoundation\Request;

class ProductGenerator implements GeneratorInterface
{
    public function supportsRequest(Request $request, string $route): bool
    {
        return $request->attributes->has('product-id');
    }

    public function supportsElement($element): bool
    {
        return false;
    }

    public function generateForRequest(Graph $graph, Request $request, array &$schemaBlocks): void
    {
        $graph
            ->product()
                ->name('My cool Product')
                ->brand($graph->organization());
    }

    public function generateForElement($element): ?BaseType
    {
        // return null since we do not support requests
        return null;
    }
}
```

***

## III. Twig Usage Example

### Render json-ld data directly in twig templates
You're able to render json-ld data in your markup. For this you need to make use of the `json_ld` twig extension.

### Register Service

```yml
App\Schema\Generator\ProductGenerator:
    autowire: true
    tags:
        - { name: schema.generator, alias: product }
```

### Build Service

```php
<?php

namespace App\Schema\Generator;

use Pimcore\Model\DataObject\TestClass;
use SchemaBundle\Generator\GeneratorInterface;
use Spatie\SchemaOrg\BaseType;
use Spatie\SchemaOrg\Graph;
use Spatie\SchemaOrg\Schema;
use Symfony\Component\HttpFoundation\Request;

class ProductGenerator implements GeneratorInterface
{
    public function supportsRequest(Request $request, string $route): bool
    {
        return false;
    }

    public function supportsElement($element): bool
    {
        return $element instanceof TestClass;
    }

    public function generateForRequest(Graph $graph, Request $request, array &$schemaBlocks): void
    {
        // nothing to do since we do not support requests
    }

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
