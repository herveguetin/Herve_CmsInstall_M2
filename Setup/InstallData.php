<?php
/**
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author Hervé Guétin <herve.guetin@gmail.com> <@herveguetin>
 * @copyright Copyright (c) 2016 Agence Soon (http://www.agence-soon.fr)
 */

namespace Herve\CmsInstall\Setup;


use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Cms\Api\Data\BlockInterface;
use Magento\Cms\Api\Data\BlockInterfaceFactory;
use Magento\Cms\Api\Data\PageInterface;
use Magento\Cms\Api\Data\PageInterfaceFactory;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    /**
     * @var BlockRepositoryInterface
     */
    private $blockRepository;
    /**
     * @var BlockInterfaceFactory
     */
    private $blockInterfaceFactory;
    /**
     * @var PageRepositoryInterface
     */
    private $pageRepository;
    /**
     * @var PageInterfaceFactory
     */
    private $pageInterfaceFactory;

    public function __construct(
        BlockRepositoryInterface $blockRepository,
        BlockInterfaceFactory $blockInterfaceFactory,
        PageRepositoryInterface $pageRepository,
        PageInterfaceFactory $pageInterfaceFactory
    ) {
        $this->blockRepository = $blockRepository;
        $this->blockInterfaceFactory = $blockInterfaceFactory;
        $this->pageRepository = $pageRepository;
        $this->pageInterfaceFactory = $pageInterfaceFactory;
    }

    /**
     * Installs data for a module
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->createCmsBlock();
        $this->createCmsPage();
    }

    /**
     * Create a CMS block
     */
    public function createCmsBlock()
    {
        /** @var BlockInterface $cmsBlock */
        $cmsBlock = $this->blockInterfaceFactory->create();
        $cmsBlock->setIdentifier('block-identifier')
            ->setTitle('Block Title')
            ->setContent('Block Content')
            ->setData('stores', [0]);

        $this->blockRepository->save($cmsBlock);
    }

    /**
     * Create a CMS page
     */
    private function createCmsPage()
    {
        /** @var PageInterface $cmsPage */
        $cmsPage = $this->pageInterfaceFactory->create();
        $cmsPage->setIdentifier('page-identifier')
            ->setTitle('Page Title')
            ->setContentHeading('Content Heading')
            ->setContent('Page HTML content')
            ->setPageLayout('1column')
            ->setData('stores', [0]);

        $this->pageRepository->save($cmsPage);
    }
}