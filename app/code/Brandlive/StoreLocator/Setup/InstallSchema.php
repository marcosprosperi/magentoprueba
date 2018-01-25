<?php

namespace Vendor\Module\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Cms\Model\PageFactory;

class InstallData implements InstallDataInterface
{
    /**
     * @var \Magento\Cms\Model\PageFactory
     */
    protected $pageFactory;

    /**
     * Construct
     *
     * @param \Magento\Cms\Model\PageFactory $pageFactory
     */
    public function __construct(
        PageFactory $pageFactory
    ) {
        $this->pageFactory = $pageFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function install(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $setup->startSetup();

//        $page = $this->pageFactory->create();
//        $page->setTitle('Example CMS page')
//            ->setIdentifier('example-cms-page')
//            ->setIsActive(true)
//            ->setPageLayout('1column')
//            ->setStores(array(0))
//            ->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit.')
//            ->save();

        $setup->endSetup();
    }
}
