/**
 * Copyright © 2016 Wyomind. All rights reserved.
 * https://www.wyomind.com
 */
var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/view/shipping': {
                'Wyomind_PickupAtStore/js/view/shipping': true
            },
            'Magento_Checkout/js/model/checkout-data-resolver': {
                'Wyomind_PickupAtStore/js/model/checkout-data-resolver': true
            },
            'Magento_Checkout/js/view/shipping-information': {
                'Wyomind_PickupAtStore/js/view/shipping-information': true
            },
            'Magento_Checkout/js/view/billing-address': {
                'Wyomind_PickupAtStore/js/view/billing-address' : true
            }
        }
    }
};