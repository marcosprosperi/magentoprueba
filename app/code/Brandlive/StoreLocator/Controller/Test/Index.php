<?php
namespace Brandlive\StoreLocator\Controller\Test;


class Index extends \Magento\Framework\App\Action\Action
{
    public function execute()
    {
        $contactModel = $this->_objectManager->create('Brandlive\StoreLocator\Model\StoreLocator');
        $collection = $contactModel->getCollection()->addFieldToFilter('country_id', array('eq'=> 'ar'));
        foreach($collection as $contact) {
            var_dump($contact->getData());
        }   
    }
}

