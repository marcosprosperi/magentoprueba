<?php

namespace Brandlive\StoreLocator\Model\ResourceModel\StoreLocator;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;


class Collection extends AbstractCollection
{
    /**
     * Initialize resource collection
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('Brandlive\StoreLocator\Model\StoreLocator', 'Brandlive\StoreLocator\Model\ResourceModel\StoreLocator');
    }
}
