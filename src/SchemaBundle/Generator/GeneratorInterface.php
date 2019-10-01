<?php

namespace SchemaBundle\Generator;

use Spatie\SchemaOrg\BaseType;
use Spatie\SchemaOrg\Graph;
use Symfony\Component\HttpFoundation\Request;

interface GeneratorInterface
{
    /**
     * @param Request $request
     * @param string  $route
     *
     * @return bool
     */
    public function supportsRequest(Request $request, string $route): bool;

    /**
     * @param mixed $element
     *
     * @return bool
     */
    public function supportsElement($element): bool;

    /**
     * @param Graph   $graph
     * @param Request $request
     * @param array   $schemaBlocks
     */
    public function generateForRequest(Graph $graph, Request $request, array &$schemaBlocks): void;

    /**
     * @param mixed $element
     *
     * @return null|BaseType
     */
    public function generateForElement($element): ?BaseType;
}
