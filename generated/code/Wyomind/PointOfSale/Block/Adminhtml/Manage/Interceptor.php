<?php
namespace Wyomind\PointOfSale\Block\Adminhtml\Manage;

/**
 * Interceptor class for @see \Wyomind\PointOfSale\Block\Adminhtml\Manage
 */
class Interceptor extends \Wyomind\PointOfSale\Block\Adminhtml\Manage implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\Block\Widget\Context $context, \Magento\Framework\Message\ManagerInterface $messageManager, \Wyomind\Core\Helper\Data $coreHelper, array $data = array())
    {
        $this->___init();
        parent::__construct($context, $messageManager, $coreHelper, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function _construct()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, '_construct');
        if (!$pluginInfo) {
            return parent::_construct();
        } else {
            return $this->___callPlugins('_construct', func_get_args(), $pluginInfo);
        }
    }
}
