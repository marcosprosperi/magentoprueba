<?php
namespace Wyomind\PickupAtStore\Controller\Section\Gmap;

/**
 * Interceptor class for @see \Wyomind\PickupAtStore\Controller\Section\Gmap
 */
class Interceptor extends \Wyomind\PickupAtStore\Controller\Section\Gmap implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Wyomind\Core\Helper\Data $coreHelper, \Wyomind\PickupAtStore\Helper\Data $pasHelper, \Wyomind\PointOfSale\Model\PointOfSaleFactory $posModelFactory, \Magento\Store\Model\StoreManagerInterface $storeManager)
    {
        $this->___init();
        parent::__construct($context, $coreHelper, $pasHelper, $posModelFactory, $storeManager);
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
