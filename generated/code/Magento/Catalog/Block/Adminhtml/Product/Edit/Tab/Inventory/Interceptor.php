<?php
namespace Magento\Catalog\Block\Adminhtml\Product\Edit\Tab\Inventory;

/**
 * Interceptor class for @see \Magento\Catalog\Block\Adminhtml\Product\Edit\Tab\Inventory
 */
class Interceptor extends \Magento\Catalog\Block\Adminhtml\Product\Edit\Tab\Inventory implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Magento\CatalogInventory\Model\Source\Backorders $backorders, \Magento\CatalogInventory\Model\Source\Stock $stock, \Magento\Framework\Module\Manager $moduleManager, \Magento\Framework\Registry $coreRegistry, \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry, \Magento\CatalogInventory\Api\StockConfigurationInterface $stockConfiguration, array $data = array())
    {
        $this->___init();
        parent::__construct($context, $backorders, $stock, $moduleManager, $coreRegistry, $stockRegistry, $stockConfiguration, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function toHtml()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'toHtml');
        if (!$pluginInfo) {
            return parent::toHtml();
        } else {
            return $this->___callPlugins('toHtml', func_get_args(), $pluginInfo);
        }
    }
}
