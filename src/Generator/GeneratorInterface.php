<?php

/*
 * This source file is available under two different licenses:
 *   - GNU General Public License version 3 (GPLv3)
 *   - DACHCOM Commercial License (DCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) DACHCOM.DIGITAL AG (https://www.dachcom-digital.com)
 * @license    GPLv3 and DCL
 */

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
