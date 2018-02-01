<?php
namespace Brandlive\SubZone\Controller\Adminhtml\Manage;

class Index extends \Magento\Backend\App\Action
{
    public function execute()
    {
       $this->_view->loadLayout();
       $this->_view->renderLayout();
    }
}
