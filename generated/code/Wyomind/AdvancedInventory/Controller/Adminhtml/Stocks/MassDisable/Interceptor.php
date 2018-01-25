<?php
namespace Wyomind\AdvancedInventory\Controller\Adminhtml\Stocks\MassDisable;

/**
 * Interceptor class for @see \Wyomind\AdvancedInventory\Controller\Adminhtml\Stocks\MassDisable
 */
class Interceptor extends \Wyomind\AdvancedInventory\Controller\Adminhtml\Stocks\MassDisable implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Wyomind\Core\Helper\Data $coreHelper, \Wyomind\AdvancedInventory\Helper\Data $helperData, \Wyomind\AdvancedInventory\Model\Stock $stockModel, \Wyomind\AdvancedInventory\Model\Item $itemModel, \Wyomind\PointOfSale\Model\PointOfSale $posModel, \Magento\Catalog\Model\Product $productModel, \Magento\CatalogInventory\Model\StockRegistry $stockRegistry, \Wyomind\AdvancedInventory\Helper\Journal $journalHelper, \Wyomind\AdvancedInventory\Helper\Permissions $permissionsHelper, \Magento\Framework\Registry $coreRegistry, \Magento\Store\Model\StoreManagerInterface $storeManagerInterface, \Magento\Framework\Controller\Result\RawFactory $resultRawFactory)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $coreHelper, $helperData, $stockModel, $itemModel, $posModel, $productModel, $stockRegistry, $journalHelper, $permissionsHelper, $coreRegistry, $storeManagerInterface, $resultRawFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'dispatch');
        if (!$pluginInfo) {
            return parent::dispatch($request);
        } else {
            return $this->___callPlugins('dispatch', func_get_args(), $pluginInfo);
        }
    }
}
