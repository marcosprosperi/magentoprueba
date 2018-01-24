
/**
 * Copyright © 2016 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */
advancedInventory = {
    attributes: [],
    updateStocks: function (classname) {
        advancedInventory.attributes = [];
        advancedInventory.length = jQuery(classname).length;
        jQuery(classname).each(function () {
            if (classname == ".super-attribute-select") {
                attr_id = jQuery(this).attr("attribute-id");
                if (attr_id == undefined) {
                    attr_id = jQuery(this).attr("id").replace("attribute", "");
                }
                option_id = jQuery(this).attr("option-selected");
                if (option_id == undefined && jQuery(this).val() != "") {
                    option_id = jQuery(this).val()
                }
                if (option_id != null && jQuery(this).val() != "")
                    advancedInventory.attributes.push({'id': attr_id, 'value': option_id});
            } else {
                attr_id = jQuery(this).attr("attribute-id");

                option_id = jQuery(this).find(".selected").attr("option-id");

                if (option_id != undefined && option_id != null)
                    advancedInventory.attributes.push({'id': attr_id, 'value': option_id});
            }
        });

        if (advancedInventory.length == advancedInventory.attributes.length) {
            jQuery(".notice").hide();
            if (typeof advancedInventoryData !== 'undefined' && typeof advancedInventoryData.stocks !== 'undefined') {
                jQuery.each(advancedInventoryData.stocks, function (i, s) {
                    found = true;
                    jQuery.each(advancedInventory.attributes, function (x, attr) {
                        eval("attribute = s.attribute" + attr.id);
                        if (attribute !== attr.value) {
                            found = false;
                        }
                    });
                    if (found) {
                        jQuery(".ai-status-message").html(advancedInventoryData.stocks[i].message);
                        jQuery.each(s.stock, function (i, pos) {

                            jQuery("#store_" + pos.store + " SPAN.units").html(pos.qty);

                            if (pos.qty < 1) {
                                jQuery("#store_" + pos.store + " SPAN.qty").hide();
                            } else {
                                jQuery("#store_" + pos.store + " SPAN.qty").show();
                                if (pos.qty > 1) {
                                    jQuery("#store_" + pos.store + " SPAN.qty SPAN.plurial").show();
                                } else {
                                    jQuery("#store_" + pos.store + " SPAN.qty SPAN.plurial").hide();
                                }
                            }
                            jQuery("#store_" + pos.store + " SPAN.status").attr("class", "status " + pos.status).html(eval("advancedInventoryData." + pos.status))

                        });
                    }

                });
            }
        } else {
            jQuery(".ai-status-message").html("");
            jQuery(".notice").show();
            jQuery("SPAN.qty").hide();
            jQuery("SPAN.status").attr("class", "status ").html("-")

        }
    }
};

window.onload = function () {
    require(["jquery", "mage/mage"], function ($) {
        if (advancedInventory != undefined) {
            $(function () {
                jQuery(document).on("change", ".super-attribute-select", function () {
                    advancedInventory.updateStocks(".super-attribute-select");
                });
                jQuery(document).on("click", ".swatch-attribute", function () {
                    advancedInventory.updateStocks(".swatch-attribute");
                });
            });
        }
    });
};
