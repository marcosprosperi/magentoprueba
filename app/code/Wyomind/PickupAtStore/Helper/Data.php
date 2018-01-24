<?php

/**
 * Copyright © 2016 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Wyomind\PickupAtStore\Helper;

/**
 * Useful method for Pickup@Store
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    protected $_configHelper = null;
    protected $_dateTime = null;
    protected $_checkoutSession = null;
    protected $_backendQuote = null;
    protected $_objectManager = null;
    protected $_logger = null;
    protected $_coreHelper = null;

    /**
     * Constructor
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Wyomind\PickupAtStore\Helper\Config $configHelper
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $dateTime
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Backend\Model\Session\Quote $backendQuote
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \Wyomind\PickupAtStore\Logger\Logger $logger
     * @param \Wyomind\Core\Helper\Data $coreHelper
     */
    public function __construct(
    \Magento\Framework\App\Helper\Context $context,
            \Wyomind\PickupAtStore\Helper\Config $configHelper,
            \Magento\Framework\Stdlib\DateTime\DateTime $dateTime,
            \Magento\Checkout\Model\Session $checkoutSession,
            \Magento\Backend\Model\Session\Quote $backendQuote,
            \Magento\Framework\ObjectManagerInterface $objectManager,
            \Wyomind\PickupAtStore\Logger\Logger $logger,
            \Wyomind\Core\Helper\Data $coreHelper
    )
    {

        $this->_configHelper = $configHelper;
        $this->_dateTime = $dateTime;
        $this->_checkoutSession = $checkoutSession;
        $this->_backendQuote = $backendQuote;
        $this->_objectManager = $objectManager;
        $this->_coreHelper = $coreHelper;
        parent::__construct($context);
        $this->_logger = $logger;
    }

    /**
     * Format a datetime according to the configuration of the shipping method
     * @param string $datetime
     * @return string
     */
    public function formatDatetime($datetime)
    {
        return $this->dateTranslate($this->_dateTime->gmtDate($this->_configHelper->getDateFormat() . ' ' . $this->_configHelper->getTimeFormat(), strtotime($datetime)));
    }

    /**
     * Format a date according to the configuration of the shipping method
     * @param string $datetime
     * @return string
     */
    public function formatDate($datetime)
    {
        $datetime = substr($datetime,0,10). "00:00:00";
        return $this->dateTranslate($this->_dateTime->gmtDate($this->_configHelper->getDateFormat(), strtotime($datetime)));
    }

    /**
     * Translate months and days in a formatted date/time
     * @param type $datetime
     * @return type
     */
    public function dateTranslate($datetime)
    {

        $longDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $longDaysLocale = [__('Monday'), __('Tuesday'), __('Wednesday'), __('Thursday'), __('Friday'), __('Saturday'), __('Sunday')];

        $shortDays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        $shortDaysLocale = [__('Mon'), __('Tue'), __('Wed'), __('Thu'), __('Fri'), __('Sat'), __('Sun')];

        $longMonths = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $longMonthsLocale = [__('January'), __('Februar'), __('March'), __('April'), __('May'), __('June'), __('July'), __('August'), __('September'), __('October'), __('November'), __('December')];

        $shortMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $shortMonthsLocale = [__('Jan'), __('Feb'), __('Mar'), __('Apr'), __('May'), __('Jun'), __('Jul'), __('Aug'), __('Sep'), __('Oct'), __('Nov'), __('Dec')];

        $datetime = str_replace($longDays, $longDaysLocale, $datetime);
        $datetime = str_replace($shortDays, $shortDaysLocale, $datetime);
        $datetime = str_replace($longMonths, $longMonthsLocale, $datetime);
        $datetime = str_replace($shortMonths, $shortMonthsLocale, $datetime);

        return $datetime;
    }

    /**
     * Get stores available according to Advanced Inventory
     * @param array $places
     * @return array
     */
    public function getPickupPlaces($places)
    {


        $this->_logger->notice("");
        $this->_logger->notice("");
        $this->_logger->notice("##### NEW QUOTE #####");

        $orderedItems = array();

        if ($this->_coreHelper->isAdmin()) {
            $quote = $this->_backendQuote->getQuote();
        } else {
            $quote = $this->_checkoutSession->getQuote();
        }

        if (count($quote->getAllItems()) > 0) {
            foreach ($quote->getAllItems() as $i => $item) {
                $orderedItems[$item->getItemId()]['sku'] = $item->getSku();
                if ($item->getParentItemId() == null || !isset($orderedItems[$item->getParentIdItemId()])) {
                    $orderedItems[$item->getItemId()]['qty'] = $item->getQty();
                } elseif(isset( $orderedItems[$item->getItemId()]) && isset($orderedItems[$item->getParentIdItemId()])) {
                    $orderedItems[$item->getItemId()]['qty'] = $orderedItems[$item->getParentItemId()]['qty'];
                    unset($orderedItems[$item->getParentItemId()]);
                }
                $orderedItems[$item->getItemId()]['id'] = $item->getProductId();
                $orderedItems[$item->getItemId()]['parent_item_id'] = $item->getParentItemId();
            }
        }

        $this->_logger->notice("Checking availability for quote #" . $quote->getId());

        $stockModel = $this->_objectManager->get('\Wyomind\AdvancedInventory\Model\Stock');
        $assignationModel = $this->_objectManager->get('\Wyomind\AdvancedInventory\Model\Assignation');

        $_places = array();
        foreach ($places as $place) {
            $this->_logger->notice("- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -");
            $this->_logger->notice("* Checking warehouse : " . $place->getName() . " [" . $place->getStoreCode() . "]");

            foreach ($orderedItems as $itemId => $item) {
                $this->_logger->notice(". . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . .");
                $this->_logger->notice("* * Checking availability for : " . $item['sku'] . "[ID:" . $item["id"] . "], Ordered Qty : " . $item["qty"]);
                if ($stockModel->isMultiStockEnabledByProductId($item["id"])) {
                    $available = $assignationModel->checkAvailability($item['id'], $place->getPlaceId(), $item["qty"], $itemId);
                    if ($available['status'] < 2) {
                        $this->_logger->notice("X X X X " . $place->getName() . " [" . $place->getStoreCode() . "] NOT added to the shipping methods");
                        continue 2;
                    }
                } else {
                    $this->_logger->notice("* * Multi-stock is not managed, Available!");
                }
            }
            $this->_logger->notice("V V V V " . $place->getName() . " [" . $place->getStoreCode() . "] added to the shipping methods");
            $_places[] = $place;
        }

        return $_places;
    }

}
