<?php

namespace DachcomBundle\Test\Helper;

use Codeception\Module;
use Codeception\TestInterface;
use DachcomBundle\Test\Util\FileGeneratorHelper;
use DachcomBundle\Test\Util\SchemaHelper;
use Pimcore\Model\Document\Page;
use Symfony\Component\DependencyInjection\Container;

class PimcoreBackend extends Module
{
    /**
     * @param TestInterface $test
     */
    public function _before(TestInterface $test)
    {
        FileGeneratorHelper::preparePaths();
        parent::_before($test);
    }

    /**
     * @param TestInterface $test
     */
    public function _after(TestInterface $test)
    {
        SchemaHelper::cleanUp();
        FileGeneratorHelper::cleanUp();

        parent::_after($test);
    }

    /**
     * Actor Function to create a Page Document
     *
     * @param string $documentKey
     * @param string $locale
     * @param string $action
     *
     * @return Page
     */
    public function haveAPageDocument(
        $documentKey = 'test-document',
        $locale = null,
        $action = 'default'
    ) {
        $document = $this->generatePageDocument($documentKey, $locale, $action);

        try {
            $document->save();
        } catch (\Exception $e) {
            \Codeception\Util\Debug::debug(sprintf('[SCHEMA ERROR] error while saving document page. message was: ' . $e->getMessage()));
        }

        $this->assertInstanceOf(Page::class, Page::getById($document->getId()));

        return $document;
    }


    /**
     * @return Container
     * @throws \Codeception\Exception\ModuleException
     */
    protected function getContainer()
    {
        return $this->getModule('\\' . PimcoreCore::class)->getContainer();
    }
}
