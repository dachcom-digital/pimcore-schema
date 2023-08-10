<?php

namespace SchemaBundle\Generator;

use Spatie\SchemaOrg\BaseType;

interface FragmentGeneratorInterface
{
    public function supportsElement(mixed $element): bool;

    public function generateForElement(mixed $element): ?BaseType;
}
