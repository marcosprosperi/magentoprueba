<?php

namespace Brandlive\StoreLocator\Block;

use Magento\Framework\View\Element\Template\Context;
use Magento\Directory\Model\Country;
use Wyomind\PointOfSale\Helper\Data;

class PointOfSale extends \Wyomind\PointOfSale\Block\PointOfSale
{
    private $places = null;

    public function __construct(
        Context $context,
        \Wyomind\PointOfSale\Model\PointOfSale $pointofsaleModel,
        Country $countryModel,
        Data $helper,
        array $data = []
    ) {
        parent::__construct($context, $pointofsaleModel, $countryModel, $helper, $data);
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
}
