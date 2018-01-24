<?php
 
namespace Brandlive\SubZone\Plugin;
 
class SubZonePlugin
{        

    protected $_request;
    
    
    public function __construct(\Magento\Framework\App\RequestInterface $request)
    {
        $this->_request = $request;
    }

    public function aroundExecute(\Wyomind\PointOfSale\Controller\Adminhtml\Manage\Save $subject, \Closure $proceed)
    {
        $data = $this->_request->getPost();

        $subzoneid=$data["sub_zone"];

        $returnValue = $proceed(); 

        return $returnValue;
    }
}
?>