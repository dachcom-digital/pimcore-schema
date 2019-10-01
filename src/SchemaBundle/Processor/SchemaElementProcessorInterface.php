<?php

namespace SchemaBundle\Processor;

interface SchemaElementProcessorInterface
{
    /**
     * @param $element
     *
     * @return string
     */
    public function process($element): string;
}