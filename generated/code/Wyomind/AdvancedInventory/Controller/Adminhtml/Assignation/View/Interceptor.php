<?php
namespace Wyomind\AdvancedInventory\Controller\Adminhtml\Assignation\View;

/**
 * Interceptor class for @see \Wyomind\AdvancedInventory\Controller\Adminhtml\Assignation\View
 */
class Interceptor extends \Wyomind\AdvancedInventory\Controller\Adminhtml\Assignation\View implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Wyomind\Core\Helper\Data $helperCore, \Wyomind\AdvancedInventory\Helper\Data $helperData, \Wyomind\AdvancedInventory\Model\AssignationFactory $modelAssignationFactory, \Magento\Framework\Registry $coreRegistry)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $helperCore, $helperData, $modelAssignationFactory, $coreRegistry);
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
