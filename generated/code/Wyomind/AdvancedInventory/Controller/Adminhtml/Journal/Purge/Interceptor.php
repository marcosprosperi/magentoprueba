<?php
namespace Wyomind\AdvancedInventory\Controller\Adminhtml\Journal\Purge;

/**
 * Interceptor class for @see \Wyomind\AdvancedInventory\Controller\Adminhtml\Journal\Purge
 */
class Interceptor extends \Wyomind\AdvancedInventory\Controller\Adminhtml\Journal\Purge implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Wyomind\AdvancedInventory\Model\Journal $journalModel, \Magento\Ui\Component\MassAction\Filter $filter, \Wyomind\AdvancedInventory\Model\ResourceModel\Journal\CollectionFactory $collectionFactory)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $journalModel, $filter, $collectionFactory);
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
