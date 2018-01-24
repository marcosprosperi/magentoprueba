<?php
namespace Brandlive\SubZone\Controller\Adminhtml\Manage;
use Magento\Backend\App\Action;
use Brandlive\SubZone\Model\SubZone as SubZone;

class NewAction extends \Magento\Backend\App\Action
{

    /**
     * Add A SubZone
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    
    
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;


    public function __construct(
        Action\Context $context,
        \Brandlive\SubZone\Model\ResourceModel\SubZone\CollectionFactory $subZoneCollectionFactory,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
    ) {
        $this->subZoneCollectionFactory = $subZoneCollectionFactory;
        $this->dataPersistor=$dataPersistor;
        parent::__construct($context);
    }

    public function execute()
    {
        
        $this->_view->loadLayout();
        $this->_view->renderLayout();

        $subZoneData = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($subZoneData) {
            $subZones = $this->subZoneCollectionFactory->create();
            $count = $subZones
                ->addFieldToFilter('name', array('eq'=>$subZoneData['subzone']['name']))
                ->getSize();

            if ($count > 0) {
                $this->messageManager->addErrorMessage(__('Another subzone with the same name already exists.'));
                $this->dataPersistor->set('subzone_manage', $subZoneData['subzone']);
                return $resultRedirect->setPath('*/*/newAction', $this->getRequest()->getParams());
            }

            $subZone = $this->_objectManager->create(SubZone::class);
            $subZone->setData($subZoneData)->save();
            $resultRedirect = $this->resultRedirectFactory->create();
            $this->messageManager->addSuccessMessage(__('Your subzone has been added !'));
            return $resultRedirect->setPath('*/*/index');
        }
    }
}