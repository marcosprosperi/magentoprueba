<?php

namespace Pfay\Contacts\Controller\Test;

class Index extends \Magento\Framework\App\Action\Action
{
    public function execute()
    {
        $contact = $this->_objectManager->create('Pfay\Contacts\Model\Contact');
        $contact->setName('Paul Dupond');
        $contact->save();
        die('test');
    }
}