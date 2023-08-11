<?php

namespace SchemaBundle\Processor;

use Symfony\Component\HttpFoundation\Request;

interface SchemaRequestProcessorInterface
{
    public function process(Request $request): void;
}
