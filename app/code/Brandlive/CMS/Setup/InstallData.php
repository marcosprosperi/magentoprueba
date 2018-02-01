<?php
 
namespace Brandlive\CMS\Setup;
 
use Magento\Cms\Model\PageFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
 
class InstallData implements InstallDataInterface
{
    private $pageFactory;
    private $blockFactory;
 
    public function __construct(PageFactory $pageFactory)
    {
        $this->pageFactory = $pageFactory;
    }
 
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $cmsPageData = [
            'title' => 'store locator map', // cms page title
            'page_layout' => '1column', // cms page layout
            'meta_keywords' => 'storelocatormap', // cms page meta keywords
            'meta_description' => 'store locator map', // cms page description
            'identifier' => 'storelocatormap', // cms page url identifier
            'is_active' => 1, // define active status
            'stores' => [0], // assign to stores
            'sort_order' => 0, // page sort order
            'layout_update_xml' => "<head><css src='Wyomind_PointOfSale::css/pointofsale.css'/>
            </head><body><referenceContainer name='content'>
              <block class='Magento\Framework\View\Element\Template' name='pointofsale_js' template='Brandlive_StoreLocator::pointofsale.js.phtml'/>
              <block class='Brandlive\StoreLocator\Block\PointOfSale' name='pointofsale' template='Brandlive_StoreLocator::pointofsale.phtml'/>
             </referenceContainer></body>"
        ];
 
        // create page
        $this->pageFactory->create()->setData($cmsPageData)->save();
    }
}


