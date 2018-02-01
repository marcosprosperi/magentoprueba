<?php
namespace Brandlive\ModalOverlay\Controller\Manage;

class Setup extends \Magento\Framework\App\Action\Action
{
    public function execute()
    {
        //Defino un soterne por default
        $storeName='ba';
        $formData = $this->getRequest()->getPostValue();
        $postal_code=$formData['postal_code'];

        if(!empty($postal_code)){
            $subZoneModel = $this->_objectManager->create('\Brandlive\SubZone\Model\SubZone');
        
            $subzones=$subZoneModel->getCollection();
    
            /*Recorro la colleccion de subzonas y verifico si posee el codigo postal ingresado
            en caso de que si , seteo el store_view correspondiente a la subzona*/
            foreach ($subzones as $subzone){
                $postalCodesList=explode(',',$subzone->getPostalCodes()) ;
                if (in_array($postal_code,$postalCodesList)) {
                    $storeId=$subzone->getStoreId();
                    $storeManager = $this->_objectManager->create("\Magento\Store\Model\StoreManagerInterface");
    
                    $storeName=$storeManager->getStore($storeId)->getCode();
                }
            }

            $cookie=json_decode($_COOKIE["modal-overlay"]);
            setcookie("modal-overlay","{'modal_overlay':'".$cookie->modal_overlay."','postal_code':'".$cookie->postal_code."','store':'".$storeName."'}",time()+36000,"/"); 

        }

        return $this->_redirect('/'. $storeName.'/');
    }
}


