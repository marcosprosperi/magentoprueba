<?php

namespace Brandlive\SubZone\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * SubZone Resource Model
 */
class SubZone extends AbstractDb
{
    /**
     * Initialize resource
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('brandlive_subzone', 'subzone_id');
    }
}
