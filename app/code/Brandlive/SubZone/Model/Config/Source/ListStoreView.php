<?php

namespace Brandlive\SubZone\Model\Config\Source;

class ListStoreView implements \Magento\Framework\Option\ArrayInterface
{

    /**
     * Escaper
     *
     * @var Escaper
     */
    protected $escaper;
    
    /**
     * System store
     *
     * @var SystemStore
     */
    protected $systemStore;

    /**
     * Constructor
     *
     * @param SystemStore $systemStore
     * @param Escaper $escaper
     */
    public function __construct(\Magento\Store\Model\System\Store $systemStore, \Magento\Framework\Escaper $escaper)
    {
        $this->systemStore = $systemStore;
        $this->escaper = $escaper;
    }

    public function toOptionArray()
    {
      
        return $this->generateCurrentOptions();
    }

     /**
     * Generate current options
     *
     * @return void
     */
    protected function generateCurrentOptions()
    {
        $websiteCollection = $this->systemStore->getWebsiteCollection();
        $groupCollection = $this->systemStore->getGroupCollection();
        $storeCollection = $this->systemStore->getStoreCollection();
        /** @var \Magento\Store\Model\Website $website */
        $websites = [];
        foreach ($websiteCollection as $website) {
            /** @var \Magento\Store\Model\Group $group */
            $stores = [];
            foreach ($groupCollection as $group) {
                if ($group->getWebsiteId() == $website->getId()) {
                        /** @var  \Magento\Store\Model\Store $store */
                        foreach ($storeCollection as $store) {
                            if ($store->getGroupId() == $group->getId()) {
                                $name = $this->escaper->escapeHtml($store->getName());
                                $stores[$name]['label'] = str_repeat(' ', 8) . $name;
                                $stores[$name]['value'] = $store->getId();
                            }
                        }
                }
            }

            if (!empty($stores)) {
                $name = $this->escaper->escapeHtml($website->getName());
                $websites[$name]['label'] = $name;
                $websites[$name]['value'] = array_values($stores);
            }
        }

        return array_values($websites);
    }
}