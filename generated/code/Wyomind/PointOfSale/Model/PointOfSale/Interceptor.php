<?php
namespace Wyomind\PointOfSale\Model\PointOfSale;

/**
 * Interceptor class for @see \Wyomind\PointOfSale\Model\PointOfSale
 */
class Interceptor extends \Wyomind\PointOfSale\Model\PointOfSale implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Model\Context $context, \Magento\Framework\Registry $registry, \Magento\Customer\Model\Session $session, \Wyomind\Core\Helper\Data $coreHelper, \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null, \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null, array $data = array())
    {
        $this->___init();
        parent::__construct($context, $registry, $session, $coreHelper, $resource, $resourceCollection, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getPlaces()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getPlaces');
        if (!$pluginInfo) {
            return parent::getPlaces();
        } else {
            return $this->___callPlugins('getPlaces', func_get_args(), $pluginInfo);
        }
    }
}
