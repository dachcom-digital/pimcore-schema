<?php

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
