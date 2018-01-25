<?php
namespace Brandlive\SubZone\Controller\Adminhtml\Manage\Edit;

/**
 * Interceptor class for @see \Brandlive\SubZone\Controller\Adminhtml\Manage\Edit
 */
class Interceptor extends \Brandlive\SubZone\Controller\Adminhtml\Manage\Edit implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Brandlive\SubZone\Model\SubZoneFactory $subZoneFactory, \Brandlive\SubZone\Model\ResourceModel\SubZone\CollectionFactory $subZoneCollectionFactory)
    {
        $this->___init();
        parent::__construct($context, $subZoneFactory, $subZoneCollectionFactory);
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
