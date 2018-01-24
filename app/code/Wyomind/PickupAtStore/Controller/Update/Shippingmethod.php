<?php

/**
 * Copyright © 2016 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Wyomind\PickupAtStore\Controller\Update;

/**
 * Controller to update the shipping date and hour
 */
class Shippingmethod extends \Magento\Framework\App\Action\Action
{

    protected $_quoteRepository = null;
    protected $_checkoutSession = null;
    protected $_posCollectionFactory = null;
    protected $_posHelper = null;
    protected $_configHelper = null;
    protected $_pasHelper = null;
    protected $_region = null;
    protected $_logger = null;

    /**
     * Class constructor
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Quote\Api\CartRepositoryInterface $quoteRepository
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Wyomind\PointOfSale\Model\ResourceModel\PointOfSale\CollectionFactory $posCollectionFactory
     * @param \Wyomind\PointOfSale\Helper\Data $posHelper
     * @param \Wyomind\PickupAtStore\Helper\Config $configHelper
     * @param \Wyomind\PickupAtStore\Helper\Data $pasHelper
     * @param \Magento\Directory\Model\Region $region
     * @param \Wyomind\PickupAtStore\Logger\Logger $logger
     */
    public function __construct(
    \Magento\Framework\App\Action\Context $context,
            \Magento\Quote\Api\CartRepositoryInterface $quoteRepository,
            \Magento\Checkout\Model\Session $checkoutSession,
            \Wyomind\PointOfSale\Model\ResourceModel\PointOfSale\CollectionFactory $posCollectionFactory,
            \Wyomind\PointOfSale\Helper\Data $posHelper,
            \Wyomind\PickupAtStore\Helper\Config $configHelper,
            \Wyomind\PickupAtStore\Helper\Data $pasHelper,
            \Magento\Directory\Model\Region $region,
            \Wyomind\PickupAtStore\Logger\Logger $logger
    )
    {

        $this->_quoteRepository = $quoteRepository;
        $this->_checkoutSession = $checkoutSession;
        $this->_posCollectionFactory = $posCollectionFactory;
        $this->_posHelper = $posHelper;
        $this->_configHelper = $configHelper;
        $this->_pasHelper = $pasHelper;
        $this->_region = $region;
        $this->_logger = $logger;
        parent::__construct($context);
    }

    /**
     * Update the pickup date time in the quote if needed
     * @throws InputException
     */
    public function execute()
    {
        $quote = $this->_checkoutSession->getQuote();
        $params = $this->getRequest()->getParams('data');
        if (isset($params['data'])) {
            $data = $params['data'];
        } else {
            $data = [];
        }
        if (isset($data['store'])) {
            if (isset($data['date'])) {
                $datetime = $data['date'];
                if (isset($data['time']) && $data['time'] != '0') {
                    $datetime .= " " . $data['time'];
                } else {
                    $datetime .= " 00:00";
                }
                $quote->setPickupDatetime($datetime);
            }
            $quote->setPickupStore($data['store']);
            try {
                $this->_quoteRepository->save($quote);
            } catch (\Exception $e) {
                throw new \Magento\Framework\Exception\InputException(__('Unable to save shipping information. Please check input data.'));
            }
        } else {
            $quote->setPickupDatetime(null);
            $quote->setPickupStore(null);
        }

        if ($quote->getPickupStore()) {

            $storeId = $quote->getPickupStore();
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

            $storeDetails .= str_replace("<br>", "\n", $this->_posHelper->getHours($store->getHours()));

            if ($this->_configHelper->getDropdown() && $quote->getPickupDatetime()) {
                if ($this->_configHelper->getTime()) {
                    $storeDetails .= "\n" . __('Your pickup time: ') . $this->_pasHelper->formatDatetime($quote->getPickupDatetime()) . "\n\n";
                } elseif ($this->_configHelper->getDate()) {
                    $storeDetails .= "\n" . __('Your pickup date: ') . $this->_pasHelper->formatDate($quote->getPickupDatetime()) . "\n\n";
                }
            }

            $quote->setShippingDescription($storeDetails)->save();

            $region = $this->_region->loadByCode($store->getState(), $store->getCountryCode());
            $shippingData = [
                "prefix" => "",
                "firstname" => "Store Pickup",
                "middlename" => "",
                "lastname" => $store->getName(),
                "suffix" => "",
                "company" => "",
                "street" => $store->getAddressLine1() . ($store->getAddressLine2() ? "\n" . $store->getAddressLine2() : ''),
                "city" => $store->getCity(),
                "region" => $region->getDefaultName(),
                "region_id" => $region->getDefaultId()?:"0",
                "postcode" => $store->getPostalCode(),
                "country_id" => $store->getCountryCode(),
                "telephone" => $store->getMainPhone()? : "0000000000",
                "fax" => "",
                "email" => $store->getEmail()? : "no@contact.com"
            ];
            
            $quote->getShippingAddress()->addData($shippingData)->save();
        }
    }

}
