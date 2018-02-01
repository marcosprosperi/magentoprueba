<?php

namespace Brandlive\SubZone\Model;

use Magento\Cron\Exception;
use Magento\Framework\Model\AbstractModel;

/**
 * SubZone Model
 */
class SubZone extends AbstractModel
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
        $this->_init(\Brandlive\SubZone\Model\ResourceModel\SubZone::class);
    }

}
