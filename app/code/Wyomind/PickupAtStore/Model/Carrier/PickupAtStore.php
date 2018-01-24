<?php

/**
 * Copyright © 2016 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Wyomind\PickupAtStore\Model\Carrier;

/**
 * Pickup At Store shipping method definition
 */
class PickupAtStore extends \Magento\Shipping\Model\Carrier\AbstractCarrier implements \Magento\Shipping\Model\Carrier\CarrierInterface
{

    protected $_code = \Wyomind\PickupAtStore\Helper\Config::PAS_CARRIER_CODE;
    protected $_isFixed = true;
    protected $_rateResultFactory = null;
    protected $_rateMethodFactory = null;
    protected $_posModelFactory = null;
    protected $_storeManager = null;
    protected $_coreHelper = null;
    protected $_pasHelper = null;
    protected $_request = null;

    /**
     * Constructor
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory
     * @param \Wyomind\PickupAtStore\Logger\Logger $logger
     * @param \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory
     * @param \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory
     * @param \Wyomind\PointOfSale\Model\PointOfSaleFactory $posModelFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Wyomind\Core\Helper\Data $coreHelper
     * @param \Wyomind\PickupAtStore\Helper\Data $pasHelper
     * @param array $data
     */
    public function __construct(
    \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
            \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory,
            \Wyomind\PickupAtStore\Logger\Logger $logger,
            \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory,
            \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory,
            \Wyomind\PointOfSale\Model\PointOfSaleFactory $posModelFactory,
            \Magento\Store\Model\StoreManagerInterface $storeManager,
            \Wyomind\Core\Helper\Data $coreHelper,
            \Wyomind\PickupAtStore\Helper\Data $pasHelper,
            \Wyomind\PickupAtStore\Helper\Config $configHelper,
            \Magento\Framework\HTTP\PhpEnvironment\Request $request,
            array $data = []
    )
    {
        $this->_rateResultFactory = $rateResultFactory;
        $this->_rateMethodFactory = $rateMethodFactory;
        $this->_posModelFactory = $posModelFactory;
        $this->_storeManager = $storeManager;
        $this->_coreHelper = $coreHelper;
        $this->_pasHelper = $pasHelper;
        $this->_request = $request;
        $this->_configHelper = $configHelper;
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
    }

    public function getBlock()
    {
        return "pickupatstore";
    }

    /**
     * Collect all stores available
     * @param \Magento\Quote\Model\Quote\Address\RateRequest $request
     * @return boolean
     */
    public function collectRates(\Magento\Quote\Model\Quote\Address\RateRequest $request)
    {
        if (!$this->getConfigFlag('active')) {
            return false;
        }

        $shippingPrice = $this->getConfigData('handling_fee');

        $result = $this->_rateResultFactory->create();

        if ($shippingPrice !== false) {
            $storeId = $this->_storeManager->getStore()->getId();

            if ($this->_coreHelper->isAdmin()) {
                $collection = $this->_posModelFactory->create()->getCollection();
            } else {
                $collection = $this->_posModelFactory->create()->getPlacesByStoreId($storeId, true);
            }

            if ($this->_coreHelper->moduleIsEnabled("Wyomind_AdvancedInventory")) {
                $collection = $this->_pasHelper->getPickupPlaces($collection);
            }

            if (strpos($this->_request->getUriString(), "estimate-shipping-methods") !== FALSE && $this->_configHelper->getEstimateGlobal()) {

                $posId = 0;
                $pos = null;

                if (is_array($collection)) {
                    if (isset($collection[0])) {
                        $pos = $collection[0];
                        $posId = $pos->getPlaceId();
                    }
                } else {
                    $pos = $collection->getFirstItem();
                    if ($pos) {
                        $posId = $pos->getPlaceId();
                    }
                }

                if ($pos != null) {
                    $method = $this->_rateMethodFactory->create();

                    $method->setCarrier($this->_code);
                    $method->setCarrierTitle($this->getConfigData('title'));

                    $method->setMethod($this->_code . "_" . $posId);
                    $method->setMethodTitle($this->getConfigData('title'));


                    if ($request->getFreeShipping() === true || $request->getPackageQty() == $this->getFreeBoxes()) {
                        $shippingPrice = '0.00';
                    }

                    $method->setPrice($shippingPrice);
                    $method->setCost($shippingPrice);

                    $result->append($method);
                }
            } else {

                foreach ($collection as $pos) {

                    if (!is_array($pos)) {
                        $name = $pos->getName();
                        $placeId = $pos->getPlaceId();
                    } else {
                        $name = $pos['name'];
                        $placeId = $pos['place_id'];
                    }

                    $method = $this->_rateMethodFactory->create();

                    $method->setCarrier($this->_code);
                    $method->setCarrierTitle($this->getConfigData('title'));

                    $method->setMethod($this->_code . "_" . $placeId);
                    $method->setMethodTitle($name);


                    if ($request->getFreeShipping() === true || $request->getPackageQty() == $this->getFreeBoxes()) {
                        $shippingPrice = '0.00';
                    }

                    $method->setPrice($shippingPrice);
                    $method->setCost($shippingPrice);

                    $result->append($method);
                }
            }
        }

        return $result;
    }

    public function getAllowedMethods()
    {
        return [$this->_code => $this->getConfigData('title')];
    }

}
