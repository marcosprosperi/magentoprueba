<?php
namespace Wyomind\PointOfSale\Block\Adminhtml\Manage\Grid;

/**
 * Interceptor class for @see \Wyomind\PointOfSale\Block\Adminhtml\Manage\Grid
 */
class Interceptor extends \Wyomind\PointOfSale\Block\Adminhtml\Manage\Grid implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Template\Context $context, \Magento\Backend\Helper\Data $backendHelper, \Wyomind\PointOfSale\Model\ResourceModel\PointOfSale\CollectionFactory $collectionFactory, array $data = array())
    {
        $this->___init();
        parent::__construct($context, $backendHelper, $collectionFactory, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function _prepareCollection()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, '_prepareCollection');
        if (!$pluginInfo) {
            return parent::_prepareCollection();
        } else {
            return $this->___callPlugins('_prepareCollection', func_get_args(), $pluginInfo);
        }
    }
}
