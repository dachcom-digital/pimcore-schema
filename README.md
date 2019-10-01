# Pimcore Schema
Schema.org type builder and ld+json generator for pimcore. This bundle requires the `spatie/schema-org` package. 

[![Join the chat at https://gitter.im/pimcore/pimcore](https://img.shields.io/gitter/room/pimcore/pimcore.svg?style=flat-square)](https://gitter.im/pimcore/pimcore)
[![Software License](https://img.shields.io/badge/license-GPLv3-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Latest Release](https://img.shields.io/packagist/v/dachcom-digital/schema.svg?style=flat-square)](https://packagist.org/packages/dachcom-digital/schema)
[![Travis](https://img.shields.io/travis/com/dachcom-digital/pimcore-schema/master.svg?style=flat-square)](https://travis-ci.com/dachcom-digital/pimcore-schema)
[![PhpStan](https://img.shields.io/badge/PHPStan-level%202-brightgreen.svg?style=flat-square)](#)

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

## Simple Usage Example

```yml
AppBundle\Schema\Generator\KnowledgeGraphGenerator:
    autowire: true
    tags:
        - {name: schema.generator, alias: knowledge_graph }
```

### Service

```php
<?php

namespace AppBundle\Schema\Generator;

use Spatie\SchemaOrg\Graph;
use Spatie\SchemaOrg\BaseType;
use Symfony\Component\HttpFoundation\Request;
use SchemaBundle\Generator\GeneratorInterface;

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

    /**
     * {@inheritDoc}
     */
    public function generateForElement($element): ?BaseType
    {
        return null;
    }
}
```

### Further Information
- [Add ld+json Twig Helper](docs/01_Twig_Extension.md)
- [Extended Example](docs/02_Extended_Usage.md)
