<?php
namespace Magento\CatalogInventory\Model\StockStateProvider;

/**
 * Interceptor class for @see \Magento\CatalogInventory\Model\StockStateProvider
 */
class Interceptor extends \Magento\CatalogInventory\Model\StockStateProvider implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Math\Division $mathDivision, \Magento\Framework\Locale\FormatInterface $localeFormat, \Magento\Framework\DataObject\Factory $objectFactory, \Magento\Catalog\Model\ProductFactory $productFactory, $qtyCheckApplicable = true)
    {
        $this->___init();
        parent::__construct($mathDivision, $localeFormat, $objectFactory, $productFactory, $qtyCheckApplicable);
    }

    /**
     * {@inheritdoc}
     */
    public function checkQuoteItemQty(\Magento\CatalogInventory\Api\Data\StockItemInterface $stockItem, $qty, $summaryQty, $origQty = 0)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'checkQuoteItemQty');
        if (!$pluginInfo) {
            return parent::checkQuoteItemQty($stockItem, $qty, $summaryQty, $origQty);
        } else {
            return $this->___callPlugins('checkQuoteItemQty', func_get_args(), $pluginInfo);
        }
    }
}
