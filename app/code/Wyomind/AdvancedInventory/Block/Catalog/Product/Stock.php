<?php

namespace Wyomind\AdvancedInventory\Block\Catalog\Product;

class Stock extends \Magento\Framework\View\Element\Template
{
    /* Code snippet to use in your template
     * to display the product grid
     * <?php echo $block->getLayout()->createBlock('\Wyomind\AdvancedInventory\Block\Catalog\Product\Stock')->output($_product); ?>
     * to display the point of sale message
     * <?php echo $block->getLayout()->createBlock('\Wyomind\AdvancedInventory\Block\Catalog\Product\Stock')->output($_product,"message"); ?>
     * to display both
     * <?php echo $block->getLayout()->createBlock('\Wyomind\AdvancedInventory\Block\Catalog\Product\Stock')->output($_product); ?>
     * <?php echo $block->getLayout()->createBlock('\Wyomind\AdvancedInventory\Block\Catalog\Product\Stock')->output($_product,"message",false); ?>
     *
     */

    protected $_helperCore;
    protected $_modelStock;
    protected $_modelPos;
    protected $_customerSession;
    protected $_modelEavConfig;
    protected $_jsonHelperData;
    protected $_configurable;
    protected $_product;
    protected $_cmsMapPage = 'pointofsale';
    protected $_storeId = null;
    protected $_customerId = null;

    public function __construct(
    \Magento\Framework\View\Element\Template\Context $context,
            \Wyomind\Core\Helper\Data $helperCore,
            \Wyomind\AdvancedInventory\Model\Stock $modelStock,
            \Wyomind\PointOfSale\Model\PointOfSale $modelPos,
            \Magento\Customer\Model\Session $customerSession,
            \Magento\Eav\Model\Config $modelEavConfig,
            \Magento\Framework\Json\Helper\Data $jsonHelperData,
            \Magento\ConfigurableProduct\Model\Product\Type\Configurable $configurable,
            array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->_storeId = $this->_storeManager->getStore()->getStoreId();
        $this->_customerId = $customerSession->getCustomerGroupId();
        $this->_helperCore = $helperCore;
        $this->_modelStock = $modelStock;
        $this->_modelPos = $modelPos;
        $this->_customerSession = $customerSession;
        $this->_modelEavConfig = $modelEavConfig;
        $this->_jsonHelperData = $jsonHelperData;
        $this->_configurable = $configurable;
    }

    public function getMessage()
    {
        if ($this->_helperCore->getStoreConfig("advancedinventory/settings/enabled")) {
            $rtn = "";
 
            $places = $this->_modelPos->getPlacesByStoreId($this->_storeId, true);
            $placeIds = [];
            foreach ($places as $place) {
                $placeIds[] = $place->getPlaceId();
            }
            $stocks = $this->_modelStock->getStockSettings($this->_product->getId(), false, $placeIds);

          
                foreach ($places as $place) {
                    if (!$place->getManageInventory()) {
                        continue;
                    }
                    $inCustomerGroups = in_array($this->_customerId, explode(',', $place->getCustomerGroup()));
                    $inStoreviews = in_array($this->_storeId, explode(',', $place->getStoreId()));

                    if (!$inStoreviews || !$inCustomerGroups) {
                        continue;
                    }

                    if ($this->_product->getTypeId() == \Magento\ConfigurableProduct\Model\Product\Type\Configurable::TYPE_CODE) {
                        $rtn.="<div class='ai-status-message'></div>";
                        $rtn.= "<div class='notice'>" . __("* Please configure the options to get the availability") . "</div>";
                        break;
                    } else {
                        $backorders = "backorders_" . $place->getId() . "";
                        $isInStock = "is_in_stock_" . $place->getId() . "";
                        $manageStock = "manage_stock_" . $place->getId() . "";
                        $qty = "quantity_" . $place->getId() . "";
                        $backorders = "backorders_".$place->getId();
                       if ($stocks[$manageStock] && ($stocks[$qty] > $stocks['min_qty'] || $stocks[$backorders])) {
                            $rtn.="<div class='ai-status-message'>" . $place->getStockStatusMessage() . "</div>";
                            break;
                        }
                    }
                }




                return $rtn;
            
        }
        return;
    }

    public function getGrid()
    {

        if ($this->_helperCore->getStoreConfig("advancedinventory/settings/enabled")) {

            $places = $this->_modelPos->getPlacesByStoreId($this->_storeId, true);
            $placeIds = [];
            foreach ($places as $place) {
                $placeIds[] = $place->getPlaceId();
            }
            $stocks = $this->_modelStock->getStockSettings($this->_product->getId(), false, $placeIds);

                $rtn = "<table class='data table additional-attributes'>
                 <thead>
                    <tr>
                        <th>" . __('Store') . "</th><th>" . __('Availability') . "
                        </th>
                 </thead>
                 <tbody>";

                $places = $this->_modelPos->getPlacesByStoreId($this->_storeId, true);
                $placeIds = [];
                foreach ($places as $place) {
                    $placeIds[] = $place->getPlaceId();
                }
                $stocks = $this->_modelStock->getStockSettings($this->_product->getId(), false, $placeIds);



                foreach ($places as $place) {
                    if (!$place->getManageInventory()) {
                        continue;
                    }
                    $inCustomerGroups = in_array($this->_customerId, explode(',', $place->getCustomerGroup()));
                    $inStoreviews = in_array($this->_storeId, explode(',', $place->getStoreId()));

                    if ($place->getStatus() != 1 || !$inStoreviews || !$inCustomerGroups) {
                        continue;
                    }

                    if ($this->_product->getTypeId() == \Magento\ConfigurableProduct\Model\Product\Type\Configurable::TYPE_CODE) {
                        $msg = "<span id='pos_" . $place->getId() . "'>";
                        $msg .="<span class='status in_stock'>-</span>";

                        $msg .= " <span class='qty' style='display:none;'>(<span class='units'></span> " . __("unit") . "<span class='plurial'>s</span>)</span>";

                        $msg .= "</span>";
                    } else {
                        $qty = "quantity_" . $place->getId() . "";
                        $manageStock = "manage_stock_" . $place->getId() . "";
                        $backorders = "backorders_" . $place->getId() . "";
                        $isInStock = "is_in_stock_" . $place->getId() . "";
                        $backorderAllowed = "backorder_allowed_" . $place->getId() . "";

                        if ($stocks[$isInStock]) {
                            $msg = "<span id='pos_" . $place->getId() . "'>";
                            $msg .="<span class='status in_stock'>" . __("In stock") . "</span>";
                            if ($manageStock) {
                                $units = ($stocks[$qty] > 1) ? __("units") : __("unit");
                                $msg .= " <span class='qty'> (<span class='units'>" . $stocks[$qty] . "</span> " . $units . ")</span>";
                            }
                            $msg .= "</span>";
                        } elseif ($stocks[$backorders]) {
                            $msg = "<span id='pos_" . $place->getId() . "'>";
                            if ($stocks[$backorderAllowed] > 1) {
                                $msg .="<span class='status backorder'>" . __("Backorder") . "</span>";
                            } else {
                                $msg .="<span class='status in_stock'>" . __("In stock") . "</span>";
                            }
                            $msg .= "</span>";
                        } else {
                            $msg = "<span id='pos_" . $place->getId() . "'>";
                            $msg .="<span class='status out_of_stock'>" . __("Out of stock") . "</span>";
                            $msg .= "</span>";
                        }
                    }
                    $rtn.="<tr class='ai_store' id='store_" . $place->getId() . "'>";
                    $rtn.= "<td>" . $place->getName() . "</td>";
                    $rtn.="<td>" . $msg . "</td>";
                    $rtn.="</tr>";
                }

                $rtn.="<tr>"
                        . "<td>"
                        . "<a target='_blank' href='" . $this->_urlBuilder->getUrl($this->_cmsMapPage) . "'>" . __('Find the nearest store') . "</a>
                    </td>";
                if ($this->_product->getTypeId() == \Magento\ConfigurableProduct\Model\Product\Type\Configurable::TYPE_CODE) {
                    $rtn .= "<td><div class='notice'>" . __("* Please configure the options to get the availability") . "</div></td>";
                } else {
                    $rtn .= "<td></td>";
                }
                $rtn .= "</tr>
                </tbody>
            </table>";

                return $rtn;
            
        }
        return;
    }

    public function getJson()
    {
        if ($this->_helperCore->getStoreConfig("advancedinventory/settings/enabled")) {

            $places = $this->_modelPos->getPlacesByStoreId($this->_storeId, true);
            $placeIds = [];
            foreach ($places as $place) {
                $placeIds[] = $place->getPlaceId();
            }
            $stocks = $this->_modelStock->getStockSettings($this->_product->getId(), false, $placeIds);

                if ($this->_product->getTypeId() == \Magento\ConfigurableProduct\Model\Product\Type\Configurable::TYPE_CODE) {


                    $attributes = [];
                    $attributesTmp = $this->_product->getTypeInstance(true)->getConfigurableAttributes($this->_product);
                    foreach ($attributesTmp as $_attribute) {
                        $attributes[] = $this->_modelEavConfig->getAttribute('catalog_product', $_attribute->getAttributeId());
                    }



                    $associatedProduct = $this->_product->getTypeInstance()->getUsedProducts($this->_product);
                    $children = [];
                    $i = 0;
                    $placeIds = [];
                    $places = $this->_modelPos->getPlaces();
                    foreach ($places as $place) {
                        $placeIds[] = $place->getPlaceId();
                    }



                    foreach ($associatedProduct as $child) {
                        $stocks = $this->_modelStock->getStockSettings($child->getId(), false, $placeIds);
                        foreach ($attributes as $attr) {
                            $children[$i]["attribute" . $attr->getAttributeId()] = $child->getData($attr->getAttributeCode());
                        }

                        foreach ($places as $place) {
                            $inCustomerGroups = in_array($this->_customerId, explode(',', $place->getCustomerGroup()));
                            $inStoreviews = in_array($this->_storeId, explode(',', $place->getStoreId()));
                            if ($place->getStatus() != 1 || !$inStoreviews || !$inCustomerGroups) {
                                continue;
                            }

                            $qty = "quantity_" . $place->getId() . "";
                            $manageStock = "manage_stock_" . $place->getId() . "";
                            $backorders = "backorders_" . $place->getId() . "";
                            $backorderAllowed = "backorder_allowed_" . $place->getId() . "";
                            $isInStock = "is_in_stock_" . $place->getId() . "";


                            if ($stocks[$isInStock]) {
                                $status = "in_stock";
                                if (!isset($children[$i]["message"])) {
                                    $children[$i]["message"] = $place->getStockStatusMessage();
                                }
                            } else {
                                if ($stocks[$backorders]) {
                                    if ($stocks[$backorderAllowed] > 1) {
                                        $status = "backorder";
                                    } else {
                                        $status = "in_stock";
                                    }
                                    if (isset($children[$i]["message"])) {
                                        $children[$i]["message"] = $place->getStockStatusMessage();
                                    }
                                } else {
                                    $status = "out_of_stock";
                                }
                            }

                            $children[$i]['stock'][] = ["store" => $place->getPlaceId(), "qty" => $stocks[$qty], "status" => $status];
                        }


                        $i++;
                    };

                    return '<script type="text/javascript">
                     advancedInventoryData={
                        stocks:' . $this->_jsonHelperData->jsonEncode($children) . ',
                        in_stock :"' . __("In stock") . '",
                        out_of_stock:"' . __("Out of stock") . '",
                        backorder:"' . __("Backorder") . '"
                    }
                  </script>
               ';
                }
            
        }
    }

    public function output($_product, $type = "grid", $includeJson = true)
    {
        $this->_product = $_product;
        $html = "";
        if ($includeJson) {
            $html.=$this->getJson();
        }
        if ($type == "grid") {
            $html.=$this->getGrid();
        }
        if ($type == "message") {
            $html.=$this->getMessage();
        }
        return $html;
    }

}
