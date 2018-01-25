<?php
namespace Wyomind\Core\Helper\Data;

/**
 * Proxy class for @see \Wyomind\Core\Helper\Data
 */
class Proxy extends \Wyomind\Core\Helper\Data implements \Magento\Framework\ObjectManager\NoninterceptableInterface
{
    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager = null;

    /**
     * Proxied instance name
     *
     * @var string
     */
    protected $_instanceName = null;

    /**
     * Proxied instance
     *
     * @var \Wyomind\Core\Helper\Data
     */
    protected $_subject = null;

    /**
     * Instance shareability flag
     *
     * @var bool
     */
    protected $_isShared = null;

    /**
     * Proxy constructor
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param string $instanceName
     * @param bool $shared
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\Wyomind\\Core\\Helper\\Data', $shared = true)
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
        $this->_isShared = $shared;
    }

    /**
     * @return array
     */
    public function __sleep()
    {
        return ['_subject', '_isShared', '_instanceName'];
    }

    /**
     * Retrieve ObjectManager from global scope
     */
    public function __wakeup()
    {
        $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    }

    /**
     * Clone proxied instance
     */
    public function __clone()
    {
        $this->_subject = clone $this->_getSubject();
    }

    /**
     * Get proxied instance
     *
     * @return \Wyomind\Core\Helper\Data
     */
    protected function _getSubject()
    {
        if (!$this->_subject) {
            $this->_subject = true === $this->_isShared
                ? $this->_objectManager->get($this->_instanceName)
                : $this->_objectManager->create($this->_instanceName);
        }
        return $this->_subject;
    }

    /**
     * {@inheritdoc}
     */
    public function getMagentoVersion()
    {
        return $this->_getSubject()->getMagentoVersion();
    }

    /**
     * {@inheritdoc}
     */
    public function camelize($xe3)
    {
        return $this->_getSubject()->camelize($xe3);
    }

    /**
     * {@inheritdoc}
     */
    public function getStoreConfig($xed, $xf1 = null)
    {
        return $this->_getSubject()->getStoreConfig($xed, $xf1);
    }

    /**
     * {@inheritdoc}
     */
    public function setStoreConfig($xfb, $xfc, $xff = 0)
    {
        return $this->_getSubject()->setStoreConfig($xfb, $xfc, $xff);
    }

    /**
     * {@inheritdoc}
     */
    public function getStoreConfigUncrypted($x109)
    {
        return $this->_getSubject()->getStoreConfigUncrypted($x109);
    }

    /**
     * {@inheritdoc}
     */
    public function setStoreConfigCrypted($x113, $x114, $x116 = 0)
    {
        return $this->_getSubject()->setStoreConfigCrypted($x113, $x114, $x116);
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultConfig($x120)
    {
        return $this->_getSubject()->getDefaultConfig($x120);
    }

    /**
     * {@inheritdoc}
     */
    public function isLogEnabled()
    {
        return $this->_getSubject()->isLogEnabled();
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultConfig($x12d, $x12e)
    {
        return $this->_getSubject()->setDefaultConfig($x12d, $x12e);
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultConfigUncrypted($x139)
    {
        return $this->_getSubject()->getDefaultConfigUncrypted($x139);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultConfigCrypted($x146, $x14b)
    {
        return $this->_getSubject()->setDefaultConfigCrypted($x146, $x14b);
    }

    /**
     * {@inheritdoc}
     */
    public function checkHeartbeat()
    {
        return $this->_getSubject()->checkHeartbeat();
    }

    /**
     * {@inheritdoc}
     */
    public function getLastHeartbeat()
    {
        return $this->_getSubject()->getLastHeartbeat();
    }

    /**
     * {@inheritdoc}
     */
    public function dateDiff($x1b0, $x1ad = null)
    {
        return $this->_getSubject()->dateDiff($x1b0, $x1ad);
    }

    /**
     * {@inheritdoc}
     */
    public function getDuration($x1d6)
    {
        return $this->_getSubject()->getDuration($x1d6);
    }

    /**
     * {@inheritdoc}
     */
    public function moduleIsEnabled($x1e1)
    {
        return $this->_getSubject()->moduleIsEnabled($x1e1);
    }

    /**
     * {@inheritdoc}
     */
    public function constructor($x824, $x82f)
    {
        return $this->_getSubject()->constructor($x824, $x82f);
    }

    /**
     * {@inheritdoc}
     */
    public function isAdmin()
    {
        return $this->_getSubject()->isAdmin();
    }

    /**
     * {@inheritdoc}
     */
    public function sendUploadResponse($x86f, $x87c, $x86d = 'application/octet-stream')
    {
        return $this->_getSubject()->sendUploadResponse($x86f, $x87c, $x86d);
    }

    /**
     * {@inheritdoc}
     */
    public function notice($x884)
    {
        return $this->_getSubject()->notice($x884);
    }

    /**
     * {@inheritdoc}
     */
    public function isModuleOutputEnabled($moduleName = null)
    {
        return $this->_getSubject()->isModuleOutputEnabled($moduleName);
    }
}
