<?php

namespace SchemaBundle\Processor;

use Symfony\Component\HttpFoundation\Request;

interface SchemaRequestProcessorInterface
{
    /**
     * @param Request $request
     */
    public function process(Request $request): void;
}
