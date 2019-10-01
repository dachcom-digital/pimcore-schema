<?php

namespace SchemaBundle\Processor;

interface SchemaElementProcessorInterface
{
    /**
     * @param mixed $element
     *
     * @return string
     */
    public function process($element): string;
}
