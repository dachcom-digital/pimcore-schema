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
     * @var SchemaRequestProcessorInterface
     */
    protected $schemaRequestProcessor;

    /**
     * @var RequestHelper
     */
    protected $requestHelper;

    /**
     * @var PimcoreContextResolver
     */
    protected $pimcoreContextResolver;

    /**
     * @param SchemaRequestProcessorInterface $schemaRequestProcessor
     * @param RequestHelper                   $requestHelper
     * @param PimcoreContextResolver          $contextResolver
     */
    public function __construct(
        SchemaRequestProcessorInterface $schemaRequestProcessor,
        RequestHelper $requestHelper,
        PimcoreContextResolver $contextResolver
    ) {
        $this->schemaRequestProcessor = $schemaRequestProcessor;
        $this->requestHelper = $requestHelper;
        $this->pimcoreContextResolver = $contextResolver;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', -255]
        ];
    }

    /**
     * @param RequestEvent $event
     */
    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();

        if ($event->isMasterRequest() === false) {
            return;
        }

        if ($this->pimcoreContextResolver->matchesPimcoreContext($request, PimcoreContextResolver::CONTEXT_ADMIN)) {
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
