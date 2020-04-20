# Usage with SEO Bundle

## Bootstrap
If the SEO Bundle has been installed, the Schema Bundle will implement a MetaData Middleware by default. 
This allows you to create schema blocks within the SEO Workflow.

## Simple Usage Example

```yml
AppBundle\MetaData\Extractor\SchemaDataExtractor:
    tags:
        - {name: seo.meta_data.extractor, identifier: my_schema_data_extractor }
```

### Service

```php
<?php

namespace AppBundle\MetaData\Extractor;

use SeoBundle\MetaData\Extractor\ExtractorInterface;
use SeoBundle\Model\SeoMetaDataInterface;
use Spatie\SchemaOrg\Graph;
use Spatie\SchemaOrg\Organization;

class SchemaDataExtractor implements ExtractorInterface
{
    /**
     * {@inheritdoc}
     */
    public function supports($element)
    {
        return $element instanceof MyClass;
    }

    /**
     * {@inheritdoc}
     */
    public function updateMetaData($element, ?string $locale, SeoMetaDataInterface $seoMetadata)
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