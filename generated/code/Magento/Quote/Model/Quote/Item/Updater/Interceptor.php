<?php
namespace Magento\Quote\Model\Quote\Item\Updater;

/**
 * Interceptor class for @see \Magento\Quote\Model\Quote\Item\Updater
 */
class Interceptor extends \Magento\Quote\Model\Quote\Item\Updater implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Model\ProductFactory $productFactory, \Magento\Framework\Locale\FormatInterface $localeFormat, \Magento\Framework\DataObject\Factory $objectFactory, \Magento\Framework\Serialize\Serializer\Json $serializer = null)
    {
        $this->___init();
        parent::__construct($productFactory, $localeFormat, $objectFactory, $serializer);
    }

    /**
     * {@inheritdoc}
     */
    public function update(\Magento\Quote\Model\Quote\Item $item, array $info)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'update');
        if (!$pluginInfo) {
            return parent::update($item, $info);
        } else {
            return $this->___callPlugins('update', func_get_args(), $pluginInfo);
        }
    }
}
