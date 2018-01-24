/**
 * Copyright © 2016 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */
/*jshint browser:true jquery:true*/
/*global alert*/
define(
        [
            'jquery',
            'uiComponent',
            'Magento_Checkout/js/model/quote',
            'Magento_Checkout/js/model/step-navigator',
            'Magento_Checkout/js/model/sidebar'
        ],
        function ($, Component, quote, stepNavigator, sidebarModel) {
            'use strict';
            var mixin = {
                defaults: {
                    template: 'Wyomind_PickupAtStore/shipping-information'
                },
                getShippingMethodTitle: function () {
                    var shippingMethod = quote.shippingMethod();
                    if (PickupAtStore.isPASSelected()) {
                        var details = "";
                        if (PickupAtStore.config.dropdown == "1" && PickupAtStore.config.date == "1") {
                            details = " - " + PickupAtStore.method.date;
                            if (PickupAtStore.config.time == "1") {
                                details += " - " + PickupAtStore.method.time;
                            }
                        }
                        return shippingMethod ? shippingMethod.carrier_title + " - " + shippingMethod.method_title + details : '';
                    } else {
                        return shippingMethod ? shippingMethod.carrier_title + " - " + shippingMethod.method_title : '';
                    }
                }
            };

            return function (target) {
                return target.extend(mixin);
            };
        }
);

