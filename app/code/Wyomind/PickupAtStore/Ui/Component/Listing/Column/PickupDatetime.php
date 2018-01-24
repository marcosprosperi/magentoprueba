<?php

/**
 * Copyright © 2016 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Wyomind\PickupAtStore\Ui\Component\Listing\Column;

/**
 * Render column block in the order grid
 */
class PickupDatetime extends \Magento\Ui\Component\Listing\Columns\Column
{

    protected $_orderRepository = null;
    protected $_objectManager = null;

    /**
     * Constructor
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory           $uiComponentFactory
     * @param \Wyomind\OrdersExportTool\Model\Profiles                     $profiles
     * @param \Magento\Framework\UrlInterface                              $urlInterface
     * @param \Magento\Sales\Model\Order                                   $order
     * @param array                                                        $components
     * @param array                                                        $data
     */
    public function __construct(
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Framework\ObjectManager\ObjectManager $objectManager,
        array $components = [],
        array $data = []
    ) {
        $this->_orderRepository = $orderRepository;
        $this->_objectManager = $objectManager;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
    
    /**
     * Renderer for the pickup datetime choosen by the customer
     * @param array $dataSource
     */
    public function prepareDataSource(array $dataSource)
    {
        
        if (isset($dataSource['data']['items'])) {
            // load orders
            $orderIds = [];
            foreach ($dataSource['data']['items'] as $item) {
                $orderIds[] = $item['entity_id'];
            }
            $filterGroup = $this->_objectManager->create('\Magento\Framework\Api\Search\FilterGroup');

            $filterStoreId = $this->_objectManager->create('\Magento\Framework\Api\Filter');
            $filterStoreId->setField('entity_id');
            $filterStoreId->setConditionType('in');
            $filterStoreId->setValue($orderIds);

            $filterGroup->setFilters([$filterStoreId]);
            $searchCriteria = $this->_objectManager->create('\Magento\Framework\Api\SearchCriteria');
            $searchCriteria->setFilterGroups([$filterGroup]);
            $collection = $this->_orderRepository->getList($searchCriteria);

            $orders = [];
            foreach ($collection as $order) {
                $orders[$order->getEntityId()] = $order;
            }
            foreach ($dataSource['data']['items'] as &$item) {
                $item[$this->getData('name')] = $orders[$item['entity_id']]->getPickupDatetime();
            }
        }
        return $dataSource;
    }
}
