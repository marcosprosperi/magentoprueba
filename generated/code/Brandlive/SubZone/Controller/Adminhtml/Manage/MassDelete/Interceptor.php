<?php
namespace Brandlive\SubZone\Controller\Adminhtml\Manage\MassDelete;

/**
 * Interceptor class for @see \Brandlive\SubZone\Controller\Adminhtml\Manage\MassDelete
 */
class Interceptor extends \Brandlive\SubZone\Controller\Adminhtml\Manage\MassDelete implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Brandlive\SubZone\Model\SubZoneFactory $subZoneFactory, \Brandlive\SubZone\Model\ResourceModel\SubZone\CollectionFactory $subZoneCollectionFactory, \Magento\Ui\Component\MassAction\Filter $filter)
    {
        $this->___init();
        parent::__construct($context, $subZoneFactory, $subZoneCollectionFactory, $filter);
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
