<?php

/**
 * Copyright © 2016 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Wyomind\PickupAtStore\Controller\Section;

/**
 * Magento Version controller
 */
class Gmap extends \Magento\Framework\App\Action\Action
{

    protected $_storeManager = null;
    protected $_pasHelper = null;
    protected $_coreHelper = null;
    protected $_posModelFactory = null;

    /**
     * 
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Wyomind\Core\Helper\Data $coreHelper
     * @param \Wyomind\PickupAtStore\Helper\Data $pasHelper
     * @param \Wyomind\PointOfSale\Model\PointOfSaleFactory $posModelFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
    \Magento\Framework\App\Action\Context $context,
            \Wyomind\Core\Helper\Data $coreHelper,
            \Wyomind\PickupAtStore\Helper\Data $pasHelper,
            \Wyomind\PointOfSale\Model\PointOfSaleFactory $posModelFactory,
            \Magento\Store\Model\StoreManagerInterface $storeManager
    )
    {
        $this->_coreHelper = $coreHelper;
        $this->_pasHelper = $pasHelper;
        $this->_posModelFactory = $posModelFactory;
        $this->_storeManager = $storeManager;
        parent::__construct($context);
    }

    /**
     * Get the Point Of Sale map block
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $layout = $this->_view->getLayout();
        $block = $layout->createBlock('\Wyomind\PointOfSale\Block\PointOfSale');
        $block->setTemplate("Wyomind_PointOfSale::pointofsale.phtml");
        $block->setPlaces($this->getPickupPlaces());
        $this->getResponse()->appendBody($block->toHtml());
    }

    /**
     * Get the stores available for pickup (filtered by Advanced Inventory, if needed)
     * @return array
     */
    public function getPickupPlaces()
    {
        $places = null;
        if ($this->_coreHelper->moduleIsEnabled("Wyomind_AdvancedInventory")) {
            $storeId = $this->_storeManager->getStore()->getId();
            $places = $this->_posModelFactory->create()->getPlacesByStoreId($storeId, true);
            $places = $this->_pasHelper->getPickupPlaces($places);
        }
        return $places;
    }

}
