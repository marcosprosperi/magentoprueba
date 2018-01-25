<?php
namespace Wyomind\Core\Model\Notifications;

/**
 * Interceptor class for @see \Wyomind\Core\Model\Notifications
 */
class Interceptor extends \Wyomind\Core\Model\Notifications implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Model\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\Module\ModuleList $moduleList, \Magento\Framework\App\Config\MutableScopeConfigInterface $scopeConfig, \Magento\Framework\UrlInterface $urlBuilder, \Magento\Framework\Session\SessionManagerInterface $session, \Wyomind\Core\Helper\Data $coreHelper, \Magento\Framework\Filesystem\Directory\ReadFactory $directoryRead, \Magento\Framework\Filesystem\File\ReadFactory $fileRead, \Magento\Framework\App\Filesystem\DirectoryList $directoryList, \Wyomind\Core\Logger\Logger $logger, \Magento\Backend\Model\Auth\Session $auth, \Magento\Framework\HTTP\PhpEnvironment\Request $request, \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null, \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null, array $data = array())
    {
        $this->___init();
        parent::__construct($context, $registry, $moduleList, $scopeConfig, $urlBuilder, $session, $coreHelper, $directoryRead, $fileRead, $directoryList, $logger, $auth, $request, $resource, $resourceCollection, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getText()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getText');
        if (!$pluginInfo) {
            return parent::getText();
        } else {
            return $this->___callPlugins('getText', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isDisplayed()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isDisplayed');
        if (!$pluginInfo) {
            return parent::isDisplayed();
        } else {
            return $this->___callPlugins('isDisplayed', func_get_args(), $pluginInfo);
        }
    }
}
