<?php

namespace SchemaBundle\Twig\Extension;

use SchemaBundle\Processor\SchemaElementProcessorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class JsonLdExtension extends AbstractExtension
{
    /**
     * @var SchemaElementProcessorInterface
     */
    protected $schemaElementProcessor;

    /**
     * @param SchemaElementProcessorInterface $schemaElementProcessor
     */
    public function __construct(SchemaElementProcessorInterface $schemaElementProcessor)
    {
        $this->schemaElementProcessor = $schemaElementProcessor;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return [
            new TwigFilter('json_ld', [$this, 'jsonLdFilter'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * @param mixed $element
     *
     * @return mixed
     */
    public function jsonLdFilter($element)
    {
        return $this->schemaElementProcessor->process($element);
    }
}
