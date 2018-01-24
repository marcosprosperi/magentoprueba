<?php

/**
 * Copyright © 2016 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Wyomind\AdvancedInventory\Plugin\Quote\Model\Quote\Item;

class ToOrderItem
{

    public function aroundConvert(
    \Magento\Quote\Model\Quote\Item\ToOrderItem $subject,
            \Closure $proceed,
            \Magento\Quote\Model\Quote\Item\AbstractItem $item,
            $additional = []
    )
    {
        $orderItem = $proceed($item, $additional);
        $orderItem->setPreAssignation($item->getPreAssignation());
        return $orderItem;
    }

}
