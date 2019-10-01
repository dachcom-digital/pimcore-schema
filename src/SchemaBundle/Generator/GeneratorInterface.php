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
     * @param $element
     *
     * @return mixed
     */
    public function supportsElement($element): bool;

    /**
     * @param Graph   $graph
     * @param Request $request
     * @param array   $schemaBlocks
     */
     public function generateForRequest(Graph $graph, Request $request, array &$schemaBlocks): void;

    /**
     * @param $element
     *
     * @return mixed
     */
     public function generateForElement($element): ?BaseType;
}
