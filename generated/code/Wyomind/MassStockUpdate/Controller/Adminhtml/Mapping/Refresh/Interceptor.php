<?php
namespace Wyomind\MassStockUpdate\Controller\Adminhtml\Mapping\Refresh;

/**
 * Interceptor class for @see \Wyomind\MassStockUpdate\Controller\Adminhtml\Mapping\Refresh
 */
class Interceptor extends \Wyomind\MassStockUpdate\Controller\Adminhtml\Mapping\Refresh implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Wyomind\MassStockUpdate\Logger\Logger $logger, \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory, \Magento\Framework\Controller\Result\RawFactory $resultRawFactory, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Wyomind\MassStockUpdate\Model\ProfilesFactory $profileModelFactory, \Wyomind\MassStockUpdate\Helper\Data $dataHelper, \Wyomind\MassStockUpdate\Helper\Config $configHelper)
    {
        $this->___init();
        parent::__construct($context, $logger, $resultForwardFactory, $resultRawFactory, $resultPageFactory, $profileModelFactory, $dataHelper, $configHelper);
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
