<?php
namespace Wyomind\AdvancedInventory\Controller\Rss\Feed;

/**
 * Interceptor class for @see \Wyomind\AdvancedInventory\Controller\Rss\Feed
 */
class Interceptor extends \Wyomind\AdvancedInventory\Controller\Rss\Feed implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Rss\Model\RssManager $rssManager, \Magento\Rss\Model\RssFactory $rssFactory, \Magento\Customer\Model\Session $customerSession, \Magento\Customer\Api\AccountManagementInterface $customerAccountManagement, \Magento\Framework\HTTP\Authentication $httpAuthentication, \Psr\Log\LoggerInterface $logger, \Magento\Backend\Model\Auth $auth)
    {
        $this->___init();
        parent::__construct($context, $rssManager, $rssFactory, $customerSession, $customerAccountManagement, $httpAuthentication, $logger, $auth);
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
