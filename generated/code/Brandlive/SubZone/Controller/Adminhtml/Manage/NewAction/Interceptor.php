<?php
namespace Brandlive\SubZone\Controller\Adminhtml\Manage\NewAction;

/**
 * Interceptor class for @see \Brandlive\SubZone\Controller\Adminhtml\Manage\NewAction
 */
class Interceptor extends \Brandlive\SubZone\Controller\Adminhtml\Manage\NewAction implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Brandlive\SubZone\Model\ResourceModel\SubZone\CollectionFactory $subZoneCollectionFactory, \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor)
    {
        $this->___init();
        parent::__construct($context, $subZoneCollectionFactory, $dataPersistor);
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
