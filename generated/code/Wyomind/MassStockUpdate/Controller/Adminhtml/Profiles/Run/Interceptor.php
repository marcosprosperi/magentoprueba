<?php
namespace Wyomind\MassStockUpdate\Controller\Adminhtml\Profiles\Run;

/**
 * Interceptor class for @see \Wyomind\MassStockUpdate\Controller\Adminhtml\Profiles\Run
 */
class Interceptor extends \Wyomind\MassStockUpdate\Controller\Adminhtml\Profiles\Run implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Wyomind\MassStockUpdate\Logger\Logger $logger, \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory, \Magento\Framework\Controller\Result\RawFactory $resultRawFactory, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Framework\Model\Context $contextModel, \Magento\Framework\Registry $coreRegistry, \Wyomind\MassStockUpdate\Helper\Config $configHelper, \Magento\Framework\Filesystem\Directory\ReadFactory $directoryRead)
    {
        $this->___init();
        parent::__construct($context, $logger, $resultForwardFactory, $resultRawFactory, $resultPageFactory, $contextModel, $coreRegistry, $configHelper, $directoryRead);
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
