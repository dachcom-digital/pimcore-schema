# Usage with SEO Bundle

## Bootstrap
If the [SEO Bundle](https://github.com/dachcom-digital/pimcore-seo) has been installed, the Schema Bundle will implement a MetaData Middleware by default. 
This allows you to create schema blocks within the SEO Workflow.

## I. Simple Usage Example

```yml
App\MetaData\Extractor\SchemaDataExtractor:
    tags:
        - { name: seo.meta_data.extractor, identifier: my_schema_data_extractor }
```

### Service

```php
<?php

namespace App\MetaData\Extractor;

use SeoBundle\MetaData\Extractor\ExtractorInterface;
use SeoBundle\Model\SeoMetaDataInterface;
use Spatie\SchemaOrg\Graph;
use Spatie\SchemaOrg\Organization;

class SchemaDataExtractor implements ExtractorInterface
{
    public function supports($element): bool
    {
        return $element instanceof MyClass;
    }

    public function updateMetaData($element, ?string $locale, SeoMetaDataInterface $seoMetadata): void
    {
        $graphMiddleware = $seoMetadata->getMiddleware('schema_graph');

        $graphMiddleware->addTask(function (SeoMetaDataInterface $seoMetadata, Graph $graph) {
            /** @var Organization $organisation */
            $organisation = $graph->getOrCreate(Organization::class);
            $organisation->name('My Organisation');
            $organisation->description('My Organisation Description');
        });
    }
}
```

### Adding Schema Data
As you can see, you don't need to add any data to the SeoMetaData Object. This task will be dispatched by the middleware class itself.
After all extractors have been dispatched, a schema block will be added to your meta block.

This allows you to add multiple schema information within multiple extractors but only one schema block will be generated!

***

## II. Twig Usage

### Render json-ld data directly in twig templates
You're able to render json-ld data in your markup. For this you need to make use of the `json_ld_fragment` twig extension.

### Register Service

```yml
App\Schema\Generator\ProductFragmentGenerator:
    autowire: true
    tags:
        - { name: schema.fragment_generator, alias: product }
```

### Build Service

```php
<?php

namespace App\Schema\Generator;

use Pimcore\Model\DataObject\MyClass;
use SchemaBundle\Generator\FragmentGeneratorInterface;
use Spatie\SchemaOrg\BaseType;
use Spatie\SchemaOrg\Schema;

class ProductFragmentGenerator implements FragmentGeneratorInterface
{
    public function supportsElement($element): bool
    {
        return $element instanceof MyClass;
    }

    public function generateForElement($element): ?BaseType
    {
        /** @var MyClass $product */
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
    <h3>json ld fragment for object</h3>
    {% set object = pimcore_object(41) %}
    {{ object|json_ld_fragment }}
</div>
```

### Notes
Create a simple symfony service if you need to do things twice!