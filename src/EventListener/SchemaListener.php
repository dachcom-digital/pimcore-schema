<?php

namespace SchemaBundle\EventListener;

use Pimcore\Http\Request\Resolver\PimcoreContextResolver;
use Pimcore\Http\RequestHelper;
use SchemaBundle\Processor\SchemaRequestProcessorInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SchemaListener implements EventSubscriberInterface
{
    /**
     * This service is only available in standalone mode.
     * If you've installed the SEO Bundle, this class is not available!
     */
    public function __construct(
        protected SchemaRequestProcessorInterface $schemaRequestProcessor,
        protected RequestHelper $requestHelper,
        protected PimcoreContextResolver $pimcoreContextResolver
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', -255]
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        if ($event->isMainRequest() === false) {
            return;
        }

        if (!$this->pimcoreContextResolver->matchesPimcoreContext($request, PimcoreContextResolver::CONTEXT_DEFAULT)) {
            return;
        }

        if ($this->requestHelper->isFrontendRequestByAdmin($request)) {
            return;
        }

        if (php_sapi_name() === 'cli') {
            return;
        }

        $this->schemaRequestProcessor->process($request);
    }
}
