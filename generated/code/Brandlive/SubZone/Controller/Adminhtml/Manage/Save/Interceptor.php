<?php
namespace Brandlive\SubZone\Controller\Adminhtml\Manage\Save;

/**
 * Interceptor class for @see \Brandlive\SubZone\Controller\Adminhtml\Manage\Save
 */
class Interceptor extends \Brandlive\SubZone\Controller\Adminhtml\Manage\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Directory\Model\ResourceModel\Region\Collection $regionCollection, \Magento\Framework\Registry $coreRegistery, \Wyomind\PointOfSale\Model\ResourceModel\PointOfSale\Collection $posCollection, \Wyomind\PointOfSale\Model\PointOfSaleFactory $posModelFactory, \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory, \Magento\Framework\Controller\Result\RawFactory $resultRawFactory, \Wyomind\Core\Helper\Data $coreHelper, \Magento\Framework\Filesystem $filesystem, \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $regionCollection, $coreRegistery, $posCollection, $posModelFactory, $resultForwardFactory, $resultRawFactory, $coreHelper, $filesystem, $dataPersistor);
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
