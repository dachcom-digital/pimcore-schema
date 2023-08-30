# Pimcore Schema Bundle
Schema.org type builder and ld+json generator for pimcore. 
This bundle requires the `spatie/schema-org` package. 

[![Join the chat at https://gitter.im/pimcore/pimcore](https://img.shields.io/gitter/room/pimcore/pimcore.svg?style=flat-square)](https://gitter.im/pimcore/pimcore)
[![Software License](https://img.shields.io/badge/license-GPLv3-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Latest Release](https://img.shields.io/packagist/v/dachcom-digital/schema.svg?style=flat-square)](https://packagist.org/packages/dachcom-digital/schema)
[![Tests](https://img.shields.io/github/actions/workflow/status/dachcom-digital/pimcore-schema/.github/workflows/codeception.yml?branch=master&style=flat-square&logo=github&label=codeception)](https://github.com/dachcom-digital/pimcore-schema/actions?query=workflow%3ACodeception+branch%3Amaster)
[![PhpStan](https://img.shields.io/github/actions/workflow/status/dachcom-digital/pimcore-schema/.github/workflows/php-stan.yml?branch=master&style=flat-square&logo=github&label=phpstan%20level%204)](https://github.com/dachcom-digital/pimcore-schema/actions?query=workflow%3A"PHP+Stan"+branch%3Amaster)

### Release Plan

| Release | Supported Pimcore Versions | Supported Symfony Versions | Release Date | Maintained     | Branch |
|---------|----------------------------|----------------------------|--------------|----------------|--------|
| **3x**  | `11.0`                     | `6.2`                      | 30.08.2023   | Feature Branch | master |
| **2.x** | `10.1` - `10.6`            | `5.4`                      | 14.10.2021   | Bugfixes       | 2.x    |
| **1.x** | `6.0` - `6.9`              | `3.4`, `^4.4`              | 01.10.2019   | Unsupported    | 1.x    |

## Installation

```json
"require" : {
    "dachcom-digital/schema" : "~3.0.0",
}
```

Add Bundle to `bundles.php`:
```php
return [
    SchemaBundle\SchemaBundle::class => ['all' => true],
];
```

- Execute: `$ bin/console pimcore:bundle:install SchemaBundle`

## Upgrading
- Execute: `$ bin/console doctrine:migrations:migrate --prefix 'SchemaBundle\Migrations'`

## Output
![image](https://user-images.githubusercontent.com/700119/65961347-a9e22000-e456-11e9-878e-d5df75536846.png)

> [!NOTE]  
> Test your output on https://search.google.com/structured-data/testing-tool

### Further Information
- [Usage](docs/00_Usage.md)
  - [Use it with SEO Bundle](docs/01_SeoBundleUsage.md) (Recommended)
  - [Use it in Standalone Mode](docs/02_StandaloneUsage.md)

## Copyright and license
Copyright: [DACHCOM.DIGITAL](http://dachcom-digital.ch)  
For licensing details please visit [LICENSE.md](LICENSE.md)  

## Upgrade Info
Before updating, please [check our upgrade notes!](UPGRADE.md)