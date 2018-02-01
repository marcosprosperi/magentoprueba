<?php

namespace Brandlive\StoreLocator\Model;

use Magento\Cron\Exception;
use Magento\Framework\Model\AbstractModel;


class StoreLocator extends AbstractModel
{
    /**
     * @var \Magento\Framework\Stdlib\DateTime
     */
    protected $_dateTime;

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Brandlive\StoreLocator\Model\ResourceModel\StoreLocator::class);
    }
    
}
