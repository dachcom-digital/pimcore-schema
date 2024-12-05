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

namespace SchemaBundle\Twig\Extension;

use SchemaBundle\Processor\SchemaElementProcessorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class JsonLdExtension extends AbstractExtension
{
    public function __construct(protected SchemaElementProcessorInterface $schemaElementProcessor)
    {
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('json_ld', [$this, 'jsonLdFilter'], ['is_safe' => ['html']]),
            new TwigFilter('json_ld_fragment', [$this, 'jsonLdFragmentFilter'], ['is_safe' => ['html']]),
        ];
    }

    public function jsonLdFilter(mixed $element): string
    {
        return $this->schemaElementProcessor->process($element);
    }

    public function jsonLdFragmentFilter(mixed $element): string
    {
        return $this->schemaElementProcessor->processFragment($element);
    }
}
