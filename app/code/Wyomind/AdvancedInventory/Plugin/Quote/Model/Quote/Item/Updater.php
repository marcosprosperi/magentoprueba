<?php

/* *
 * Copyright © 2016 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Wyomind\AdvancedInventory\Plugin\Quote\Model\Quote\Item;

class Updater
{

    public function aroundUpdate(
    \Magento\Quote\Model\Quote\Item\updater $subject,
            \Closure $proceed,
            \Magento\Quote\Model\Quote\Item $item,
            array $info)
    {
        $value = $proceed($item, $info);
        if (!empty($info['pre_assignation'])) {
            $item->setPreAssignation($info['pre_assignation']);
        }
        return $value;
    }

}
