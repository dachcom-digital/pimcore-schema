<?php

namespace SchemaBundle\Generator;

use Spatie\SchemaOrg\BaseType;

interface FragmentGeneratorInterface
{
    /**
     * @param mixed $element
     *
     * @return bool
     */
    public function supportsElement($element): bool;

    /**
     * @param mixed $element
     *
     * @return null|BaseType
     */
    public function generateForElement($element): ?BaseType;
}
