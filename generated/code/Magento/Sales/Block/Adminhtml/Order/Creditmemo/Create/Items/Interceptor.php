<?php
namespace Magento\Sales\Block\Adminhtml\Order\Creditmemo\Create\Items;

/**
 * Interceptor class for @see \Magento\Sales\Block\Adminhtml\Order\Creditmemo\Create\Items
 */
class Interceptor extends \Magento\Sales\Block\Adminhtml\Order\Creditmemo\Create\Items implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry, \Magento\CatalogInventory\Api\StockConfigurationInterface $stockConfiguration, \Magento\Framework\Registry $registry, \Magento\Sales\Helper\Data $salesData, array $data = array())
    {
        $this->___init();
        parent::__construct($context, $stockRegistry, $stockConfiguration, $registry, $salesData, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getItemRenderer($type)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getItemRenderer');
        if (!$pluginInfo) {
            return parent::getItemRenderer($type);
        } else {
            return $this->___callPlugins('getItemRenderer', func_get_args(), $pluginInfo);
        }
    }
}
