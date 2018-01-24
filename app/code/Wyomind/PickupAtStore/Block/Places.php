<?php

/**
 * Copyright © 2016 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Wyomind\PickupAtStore\Block;

/**
 * Places block
 * This block allows the customer to select a store in a dropdown/map/list
 */
class Places extends \Magento\Framework\View\Element\Template
{

    const TEMPLATE = 'Wyomind_PickupAtStore::places.phtml';

    protected $_configHelper = null;
    protected $_posCollectionFactory = null;
    public $_posHelper = null;
    protected $_pasHelper = null;
    protected $_storeManager = null;
    protected $_coreHelper = null;

    /**
     * Constructor
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Wyomind\PickupAtStore\Helper\Config $configHelper
     * @param \Wyomind\PointOfSale\Model\PointOfSaleFactory $posModelFactory
     * @param \Wyomind\PointOfSale\Helper\Data $posHelper
     * @param \Wyomind\PickupAtStore\Helper\Data $pasHelper
     * @param \Wyomind\Core\Helper\Data $coreHelper
     * @param array $data
     */
    public function __construct(
    \Magento\Framework\View\Element\Template\Context $context,
            \Wyomind\PickupAtStore\Helper\Config $configHelper,
            \Wyomind\PointOfSale\Model\PointOfSaleFactory $posModelFactory,
            \Wyomind\PointOfSale\Helper\Data $posHelper,
            \Wyomind\PickupAtStore\Helper\Data $pasHelper,
            \Wyomind\Core\Helper\Data $coreHelper,
            array $data = []
    )
    {

        parent::__construct($context, $data);
        $this->setTemplate(self::TEMPLATE);
        $this->_configHelper = $configHelper;
        $this->_posModelFactory = $posModelFactory;
        $this->_posHelper = $posHelper;
        $this->_pasHelper = $pasHelper;
        $this->_storeManager = $context->getStoreManager();
        $this->_coreHelper = $coreHelper;
    }

    /**
     * Should the customer select the store in a dropdown ?
     * @param type $storeId
     * @return bool
     */
    public function useDropdown($storeId = null)
    {
        return $this->_configHelper->getDropdown($storeId);
    }

    /**
     * Get the title of the block on the frontend
     * @param type $storeId
     * @return string
     */
    public function getTitle($storeId = null)
    {
        return $this->_configHelper->getPickupatstoreTitle($storeId);
    }

    /**
     * Should we display the description of the stores in the list (only in list mode)
     * @param type $storeId
     * @return bool
     */
    public function getDisplayDescription($storeId = null)
    {
        return $this->_configHelper->getDisplayDescription($storeId);
    }

    /**
     * Get the places available for pickup (filtered by Advanced Inventory if needed)
     * @return array
     */
    public function getPlaces()
    {
        $storeId = $this->_storeManager->getStore()->getId();

        $places = $this->_posModelFactory->create()->getPlacesByStoreId($storeId, true);

        if ($this->_coreHelper->moduleIsEnabled("Wyomind_AdvancedInventory")) {
            $places = $this->_pasHelper->getPickupPlaces($places);
        }
        
        return $places;
    }

}
