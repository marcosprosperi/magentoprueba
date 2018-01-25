<?php
namespace Wyomind\MassStockUpdate\Controller\Adminhtml\Profiles\Ftp;

/**
 * Interceptor class for @see \Wyomind\MassStockUpdate\Controller\Adminhtml\Profiles\Ftp
 */
class Interceptor extends \Wyomind\MassStockUpdate\Controller\Adminhtml\Profiles\Ftp implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Wyomind\MassStockUpdate\Helper\Ftp $ftpHelper)
    {
        $this->___init();
        parent::__construct($context, $ftpHelper);
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
