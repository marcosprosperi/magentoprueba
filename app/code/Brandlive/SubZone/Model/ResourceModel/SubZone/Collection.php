<?php

namespace Brandlive\SubZone\Model\ResourceModel\SubZone;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * SubZone Resource Model Collection
 *
 */
class Collection extends AbstractCollection
{
    /**
     * Initialize resource collection
     *
     * @return void
     */
    protected $_idFieldName = 'subzone_id';


    public function _construct()
    {
        $this->_init('Brandlive\SubZone\Model\SubZone', 'Brandlive\SubZone\Model\ResourceModel\SubZone');
    }

    public function toOptionArray($emptyLabel = ' ')
    {
        $options = $this->_toOptionArray('subzone_id', 'name', ['title' => 'name']);

        if (count($options) > 0 && $emptyLabel !== false) {
            array_unshift($options, ['value' => '', 'label' => $emptyLabel]);
        }

        return $options;
    }
}
