<?php

namespace Wyomind\AdvancedInventory\Observer;

$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
$productMetaData = $objectManager->get("\Magento\Framework\App\ProductMetadata");
$explodedVersion = explode("-", $productMetaData->getVersion()); // in case of 2.2.0-dev
$version = $explodedVersion[0];

if (version_compare($version, "2.2.0") < 0) { // Magento 2.0/2.1

    class RefundOrderInventoryObserver extends \Magento\CatalogInventory\Observer\RefundOrderInventoryObserver
    {

        public function execute(\Magento\Framework\Event\Observer $observer)
        {
            /* @var $creditmemo \Magento\Sales\Model\Order\Creditmemo */
            $creditmemo = $observer->getEvent()->getCreditmemo();
            $itemsToUpdate = [];
            foreach ($creditmemo->getAllItems() as $item) {
                $qty = $item->getQty();
                // Wyomind - Advanced Inventory
                // if (($item->getBackToStock() && $qty) || $this->stockConfiguration->isAutoReturnEnabled()) {
                if (($item->getBackToStock() && $qty) && $this->stockConfiguration->isAutoReturnEnabled()) {
                    $productId = $item->getProductId();
                    $parentItemId = $item->getOrderItem()->getParentItemId();
                    /* @var $parentItem \Magento\Sales\Model\Order\Creditmemo\Item */
                    $parentItem = $parentItemId ? $creditmemo->getItemByOrderId($parentItemId) : false;
                    $qty = $parentItem ? $parentItem->getQty() * $qty : $qty;
                    if (isset($itemsToUpdate[$productId])) {
                        $itemsToUpdate[$productId] += $qty;
                    } else {
                        $itemsToUpdate[$productId] = $qty;
                    }
                }
            }
            if (!empty($itemsToUpdate)) {
                $this->stockManagement->revertProductsSale(
                        $itemsToUpdate, $creditmemo->getStore()->getWebsiteId()
                );

                $updatedItemIds = array_keys($itemsToUpdate);
                $this->stockIndexerProcessor->reindexList($updatedItemIds);
                $this->priceIndexer->reindexList($updatedItemIds);
            }
        }

    }

} else { // Magento 2.2

    class RefundOrderInventoryObserver extends \Magento\SalesInventory\Observer\RefundOrderInventoryObserver
    {

        public function __construct(
        \Magento\CatalogInventory\Api\StockConfigurationInterface $stockConfiguration,
                \Magento\CatalogInventory\Api\StockManagementInterface $stockManagement,
                \Magento\CatalogInventory\Model\Indexer\Stock\Processor $stockIndexerProcessor,
                \Magento\Catalog\Model\Indexer\Product\Price\Processor $priceIndexer,
                \Magento\SalesInventory\Model\Order\ReturnProcessor $returnProcessor,
                \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
        )
        {
            parent::__construct($stockConfiguration, $stockManagement, $stockIndexerProcessor, $priceIndexer, $returnProcessor, $orderRepository);
            $this->stockConfiguration = $stockConfiguration;
            $this->stockManagement = $stockManagement;
            $this->stockIndexerProcessor = $stockIndexerProcessor;
            $this->priceIndexer = $priceIndexer;
            $this->returnProcessor = $returnProcessor;
            $this->orderRepository = $orderRepository;
        }

        public function execute(\Magento\Framework\Event\Observer $observer)
        {
            /* @var $creditmemo \Magento\Sales\Model\Order\Creditmemo */
            $creditmemo = $observer->getEvent()->getCreditmemo();
            $itemsToUpdate = [];
            foreach ($creditmemo->getAllItems() as $item) {
                $qty = $item->getQty();
                // Wyomind - Advanced Inventory
                // if (($item->getBackToStock() && $qty) || $this->stockConfiguration->isAutoReturnEnabled()) {
                if (($item->getBackToStock() && $qty) && $this->stockConfiguration->isAutoReturnEnabled()) {
                    $productId = $item->getProductId();
                    $parentItemId = $item->getOrderItem()->getParentItemId();
                    /* @var $parentItem \Magento\Sales\Model\Order\Creditmemo\Item */
                    $parentItem = $parentItemId ? $creditmemo->getItemByOrderId($parentItemId) : false;
                    $qty = $parentItem ? $parentItem->getQty() * $qty : $qty;
                    if (isset($itemsToUpdate[$productId])) {
                        $itemsToUpdate[$productId] += $qty;
                    } else {
                        $itemsToUpdate[$productId] = $qty;
                    }
                }
            }
            if (!empty($itemsToUpdate)) {
                $this->stockManagement->revertProductsSale(
                        $itemsToUpdate, $creditmemo->getStore()->getWebsiteId()
                );

                $updatedItemIds = array_keys($itemsToUpdate);
                $this->stockIndexerProcessor->reindexList($updatedItemIds);
                $this->priceIndexer->reindexList($updatedItemIds);
            }
        }

    }

}