<?php

/**
 * Copyright © 2016 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Wyomind\PickupAtStore\Observer;

/**
 * Observer to update the shipping description and shipping address depending of the store choosen by the customer
 */
class SalesOrderPlaceBefore implements \Magento\Framework\Event\ObserverInterface
{

    protected $_posCollectionFactory = null;
    protected $_posHelper = null;
    protected $_configHelper = null;
    protected $_pasHelper = null;
    protected $_region = null;
    protected $_logger = null;

    public function __construct(
    \Wyomind\PointOfSale\Model\ResourceModel\PointOfSale\CollectionFactory $posCollectionFactory,
            \Wyomind\PointOfSale\Helper\Data $posHelper,
            \Wyomind\PickupAtStore\Helper\Config $configHelper,
            \Wyomind\PickupAtStore\Helper\Data $pasHelper,
            \Magento\Directory\Model\Region $region,
            \Wyomind\PickupAtStore\Logger\Logger $logger
    )
    {
        $this->_posCollectionFactory = $posCollectionFactory;
        $this->_posHelper = $posHelper;
        $this->_configHelper = $configHelper;
        $this->_pasHelper = $pasHelper;
        $this->_region = $region;
        $this->_logger = $logger;
    }

    /**

     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $order = $observer->getEvent()->getData('order');
        $shippingMethod = $order->getShippingMethod();
        if (strstr($shippingMethod, "pickupatstore") !== false) {

            $storeId = str_replace("pickupatstore_pickupatstore_", "", $shippingMethod);
            $store = $this->_posCollectionFactory->create()->getPlace($storeId)->getFirstItem();

            $storeDetails = $store->getName() . ' ';
            $storeDetails .= " [ ";
            $o = 0;
            if ($store->getAddressLine1()) {
                $storeDetails .= $store->getAddressLine1();
                $o++;
            }
            if ($store->getAddressLine2()) {
                if ($o) {
                    $storeDetails .= ", ";
                }
                $storeDetails .= $store->getAddressLine2();
                $o++;
            }
            if ($store->getCity()) {
                if ($o) {
                    $storeDetails .= ", ";
                }
                $storeDetails .= $store->getCity();
                $o++;
            }
            if ($store->getState()) {
                if ($o) {
                    $storeDetails .= ", ";
                }
                $storeDetails .= $store->getState();
                $o++;
            }
            if ($store->getPostalCode()) {
                if ($o) {
                    $storeDetails .= ", ";
                }
                $storeDetails .= $store->getPostalCode() . " ";
            }
            $storeDetails .= " ]";
            $storeDetails .= "\n";
            
            $storeDetails .= str_replace("<br>","\n",$this->_posHelper->getHours($store->getHours()));

            if ($this->_configHelper->getDropdown() && $order->getPickupDatetime()) {
                if ($this->_configHelper->getTime()) {
                    $storeDetails .= "\n" . __('Your pickup time: ') . $this->_pasHelper->formatDatetime($order->getPickupDatetime()) . "\n\n";
                } elseif ($this->_configHelper->getDate()) {
                    $storeDetails .= "\n" . __('Your pickup date: ') . $this->_pasHelper->formatDate($order->getPickupDatetime()) . "\n\n";
                }
            }

            $order->setShippingDescription($storeDetails)->save();

            $region = $this->_region->loadByCode($store->getState(), $store->getCountryCode());
            $shippingData = [
                "prefix" => "",
                "firstname" => "Store Pickup",
                "middlename" => "",
                "lastname" => $store->getName(),
                "suffix" => "",
                "company" => "",
                "street" => $store->getAddressLine1().($store->getAddressLine2()?"\n".$store->getAddressLine2():''),
                "city" => $store->getCity(),
                "region" => $region->getDefaultName(),
                "region_id" => $region->getDefaultId(),
                "postcode" => $store->getPostalCode(),
                "country_id" => $store->getCountryCode(),
                "telephone" => $store->getMainPhone()?:"0000000000",
                "fax" => "",
                "email" => $store->getEmail()?:"no@contact.com"
            ];
            $order->getShippingAddress()->addData($shippingData)->save();
            
        }
    }

}
