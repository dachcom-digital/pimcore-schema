<?php

namespace SchemaBundle\Processor;

interface SchemaElementProcessorInterface
{
    public function process(mixed $element): string;

    public function processFragment(mixed $element): string;
}
