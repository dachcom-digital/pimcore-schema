<?php

namespace SchemaBundle\Generator;

use Spatie\SchemaOrg\BaseType;
use Spatie\SchemaOrg\Graph;
use Symfony\Component\HttpFoundation\Request;

interface GeneratorInterface
{
    public function supportsRequest(Request $request, string $route): bool;

    public function supportsElement(mixed $element): bool;

    public function generateForRequest(Graph $graph, Request $request, array &$schemaBlocks): void;

    public function generateForElement(mixed $element): ?BaseType;
}
