<?php
namespace Wyomind\PickupAtStore\Controller\Update\Shippingmethod;

/**
 * Interceptor class for @see \Wyomind\PickupAtStore\Controller\Update\Shippingmethod
 */
class Interceptor extends \Wyomind\PickupAtStore\Controller\Update\Shippingmethod implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Quote\Api\CartRepositoryInterface $quoteRepository, \Magento\Checkout\Model\Session $checkoutSession, \Wyomind\PointOfSale\Model\ResourceModel\PointOfSale\CollectionFactory $posCollectionFactory, \Wyomind\PointOfSale\Helper\Data $posHelper, \Wyomind\PickupAtStore\Helper\Config $configHelper, \Wyomind\PickupAtStore\Helper\Data $pasHelper, \Magento\Directory\Model\Region $region, \Wyomind\PickupAtStore\Logger\Logger $logger)
    {
        $this->___init();
        parent::__construct($context, $quoteRepository, $checkoutSession, $posCollectionFactory, $posHelper, $configHelper, $pasHelper, $region, $logger);
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
