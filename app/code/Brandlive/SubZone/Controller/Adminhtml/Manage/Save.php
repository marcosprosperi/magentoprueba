<?php

namespace Brandlive\SubZone\Controller\Adminhtml\Manage;

class Save extends \Wyomind\PointOfSale\Controller\Adminhtml\PointOfSale
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
                \Magento\Framework\View\Result\PageFactory $resultPageFactory,
                \Magento\Directory\Model\ResourceModel\Region\Collection $regionCollection,
                \Magento\Framework\Registry $coreRegistery,
                \Wyomind\PointOfSale\Model\ResourceModel\PointOfSale\Collection $posCollection,
                \Wyomind\PointOfSale\Model\PointOfSaleFactory $posModelFactory,
                \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
                \Magento\Framework\Controller\Result\RawFactory $resultRawFactory,
                \Wyomind\Core\Helper\Data $coreHelper,
                \Magento\Framework\Filesystem $filesystem,
                \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
        )
        {
            
            $this->dataPersistor=$dataPersistor;
            parent::__construct($context,$resultPageFactory,
                                $regionCollection,
                                $coreRegistery,
                                $posCollection,
                                $posModelFactory,
                                $resultForwardFactory,
                                $resultRawFactory,
                                $coreHelper,
                                $filesystem);

        }
    

    public function execute()
    {
        $stores_ids=[];
        // check if data sent
        $data = $this->getRequest()->getPost();
        if ($data) {
            $model = $this->_objectManager->create('Wyomind\PointOfSale\Model\PointOfSale');
            $subZoneModel = $this->_objectManager->create('\Brandlive\SubZone\Model\SubZone');

            $id = $this->getRequest()->getParam('place_id');
            $ids_subzones=$data["sub_zone"];

            if ($id) {
                $model->load($id);
            }

            $postalCodesEnabled='';

            if (!is_array($ids_subzones)){
                $subzones=$subZoneModel->load($ids_subzones);
                $stores_ids[]=$subzones->getStoreId();
            }else{
                $subzones=$subZoneModel->getCollection()->addFieldToFilter('subzone_id', ['in' => $ids_subzones]);
                foreach ($subzones as $subzone){
                    if (!in_array($subzone->getStoreId(), $stores_ids)) {
                        /*Chequeo para que no se permita seleccionar dos subzonas de diferentes zonas (store)*/
                        if (count($stores_ids)==0){
                            $stores_ids[]=$subzone->getStoreId();
                        }else{
                            $this->messageManager->addError(__('Unable to save the POS.') . '<br/><br/>' . __('All Subzones must belong to the same zone.'));
                            $this->dataPersistor->set('pointofsale', $data);
                            return $this->_resultRedirectFactory->create()->setPath('pointofsale/manage/edit', ['id' => $model->getPlaceId(), '_current' => true]);
                        }      
                    }
                    /*Voy guardando los códigos postales de las subzonas seleccionadas*/
                    $postalCodesEnabled.= $postalCodesEnabled==''? $subzone->getPostalCodes():",".$subzone->getPostalCodes();
                }
            }

            /*Valido que los códigos postales ingresados esten contemplados en las subzonas seleccionadas*/
            $postalCodesEnabled=explode(",", $postalCodesEnabled);
            
            foreach (explode(",",$data["postal_code"]) as $postalCode){
                if(!in_array($postalCode, $postalCodesEnabled)){
                    $this->messageManager->addError(__('Unable to save the POS.') . '<br/><br/>' . __('The postal codes must be between the following values.') . implode(',', $postalCodesEnabled));
                    $this->dataPersistor->set('pointofsale', $data);
                    return $this->_resultRedirectFactory->create()->setPath('pointofsale/manage/edit', ['id' => $model->getPlaceId(), '_current' => true]);
                }
            }


            if (isset($data["image"]["delete"]) && $data["image"]["delete"] == 1) {
                $data["image"] = "";
            } else {
                try {
                    /* Starting upload */
                    $uploader = new \Magento\Framework\File\Uploader("image");
                    // Any extention would work
                    $uploader->setAllowedExtensions(["jpg", "jpeg", "gif", "png"]);
                    $uploader->setAllowRenameFiles(true);
                    // Set the file upload mode
                    // false -> get the file directly in the specified folder
                    // true -> get the file in the product like folders
                    //	(file.jpg will go in something like /media/f/i/file.jpg)
                    $uploader->setFilesDispersion(false);
                    $uploader->setAllowCreateFolders(true);
                    // We set media as the upload dir
                    $path = $this->_objectManager->get('Magento\Framework\App\Filesystem\DirectoryList')->getPath(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA) . DIRECTORY_SEPARATOR;

                    $uploader->save($path . "stores", null);
                    $imageName = $uploader->getUploadedFileName();
                    //this way the name is saved in DB
                    $data["image"] = "stores/" . preg_replace('/[^a-z0-9_\\-\\.]+/i', '_', $imageName);
                } catch (\Exception $e) {
                    if (isset($data["image"])) {
                        unset($data["image"]);
                    }
                }
            }


            if (in_array('-1', $data["customer_group"])) {
                $data["customer_group"] = ["-1"];
            }
            $data["customer_group"] = implode(',', $data["customer_group"]);


            $data["store_id"] = implode(',', $stores_ids);


            $data["subzone_id"]= implode(',', $ids_subzones);

            if(isset($data["store_pickup"])){
                $data["store_pickup"]=true;
            }

            if(isset($data["car_pickup"])){
                $data["car_pickup"]=true;
            }


            foreach ($data as $index => $value) {
                $model->setData($index, $value);
            }

            if (!$this->_validatePostData($data)) {
                return $this->_resultRedirectFactory->create()->setPath('pointofsale/manage/edit', ['id' => $model->getId(), '_current' => true]);
            }

            try {

                $model->save();

                $this->messageManager->addSuccess(__('The POS has been saved.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);

                if ($this->getRequest()->getParam('back_i') == "1") {
                    return $this->_resultRedirectFactory->create()->setPath('pointofsale/manage/edit', ['id' => $model->getId(), '_current' => true]);
                }

                $this->_getSession()->setFormData($data);
                return $this->_resultRedirectFactory->create()->setPath('pointofsale/manage/index');
            } catch (\Exception $e) {
                $this->messageManager->addError(__('Unable to save the POS.') . '<br/><br/>' . $e->getMessage());
                $this->dataPersistor->set('pointofsale', $data);
                return $this->_resultRedirectFactory->create()->setPath('pointofsale/manage/edit', ['id' => $model->getPlaceId(), '_current' => true]);
            }
        }
        return $this->_resultRedirectFactory->create()->setPath('pointofsale/manage/index');
    }
}
