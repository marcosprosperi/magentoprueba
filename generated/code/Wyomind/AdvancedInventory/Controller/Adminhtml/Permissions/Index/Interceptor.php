<?php
namespace Wyomind\AdvancedInventory\Controller\Adminhtml\Permissions\Index;

/**
 * Interceptor class for @see \Wyomind\AdvancedInventory\Controller\Adminhtml\Permissions\Index
 */
class Interceptor extends \Wyomind\AdvancedInventory\Controller\Adminhtml\Permissions\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Model\Context $frameworkContext, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Wyomind\Core\Helper\Data $helperCore, \Wyomind\AdvancedInventory\Helper\Data $helperData)
    {
        $this->___init();
        parent::__construct($context, $frameworkContext, $resultPageFactory, $helperCore, $helperData);
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
