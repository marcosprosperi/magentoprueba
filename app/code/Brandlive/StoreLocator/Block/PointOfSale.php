<?php

namespace Brandlive\StoreLocator\Block;

use Magento\Framework\View\Element\Template\Context;
use Magento\Directory\Model\Country;
use Wyomind\PointOfSale\Helper\Data;

class PointOfSale extends \Wyomind\PointOfSale\Block\PointOfSale
{
    /**
     * @var \Magento\Directory\Model\ResourceModel\Region\CollectionFactory
     */
    protected $regionCollectionFactory;

    protected $regionFactory;

    private $places = null;

    public function __construct(
        Context $context,
        \Wyomind\PointOfSale\Model\PointOfSale $pointofsaleModel,
        Country $countryModel,
        Data $helper,
        \Magento\Directory\Model\ResourceModel\Region\CollectionFactory $regionCollectionFactory,
        \Magento\Directory\Model\RegionFactory $regionFactory,
        array $data = []
    ) {
        parent::__construct($context, $pointofsaleModel, $countryModel, $helper, $data);
        $this->regionCollectionFactory = $regionCollectionFactory;
        $this->regionFactory = $regionFactory;
    }

    public function getPointofsale()
    {
        if ($this->places !== null) {
            $collection = $this->places;
        } else {
            $collection = $this
                ->_pointofsaleModel
                ->getPlaces()
                ->addFieldToFilter('status', ['status' => 1])
                ->setOrder('`position`', 'ASC');
        }
        return $collection;
    }

    public function getCountries()
    {
        $collection = $this->_pointofsaleModel->getCountries($this->_storeManager->getStore()->getStoreId());
        $countries = [];
        foreach ($collection as $country) {
            if ($country->getCountryCode()) {
                $countryModel = $this->_countryModel->loadByCode($country->getCountryCode());
                $countryName = $countryModel->getName();
                $countries[] = [
                    'code' => $country->getCountryCode(),
                    'name' => $countryName,
                ];
            }
        }
        return $countries;
    }

    public function getStates()
    {
        $collection = $this->regionCollectionFactory()->create();
        $states = [];
        $stateModel = $this->regionFactory->create();
        foreach($collection as $state) {
            if ($state->getCode()){
                $stateModel->loadByCode($code, $countryId);
                $stateName = $state->getName();
                $states[] = [
                    'code' => $state->getCode(),
                    'name' => $stateName ? $stateName : $state->getData('default_name')
                ];
            }
        }
    }
}
