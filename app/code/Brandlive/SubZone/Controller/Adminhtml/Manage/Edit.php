<?php
namespace Brandlive\SubZone\Controller\Adminhtml\Manage;
use Magento\Backend\App\Action;
use Brandlive\SubZone\Model\SubZone as SubZone;

class Edit extends \Magento\Backend\App\Action
{
    /**
     * Edit A SubZone Page
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected $subZoneFactory;
    protected $subZoneCollectionFactory;

    public function __construct(
        Action\Context $context,
        \Brandlive\SubZone\Model\SubZoneFactory $subZoneFactory,
        \Brandlive\SubZone\Model\ResourceModel\SubZone\CollectionFactory $subZoneCollectionFactory
    ) {
        $this->subZoneFactory = $subZoneFactory;
        $this->subZoneCollectionFactory = $subZoneCollectionFactory;

        parent::__construct($context);
    }

    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->renderLayout();

        $subZoneData = $this->getRequest()->getParam('subzone');
        if (is_array($subZoneData)) {
            $id = $subZoneData['subzone_id'];
            $subZones = $this->subZoneCollectionFactory->create();
            $count = $subZones
                ->addFieldToFilter('subzone_id', array('neq'=>$id))
                ->addFieldToFilter('name', array('eq'=>$subZoneData['name']))
                ->getSize();

            $resultRedirect = $this->resultRedirectFactory->create();

            if ($count > 0) {
                $this->messageManager->addErrorMessage(__('Another subzone with the same name already exists'));
                return $resultRedirect->setPath('*/*/edit', $this->getRequest()->getParams());
            }

            $subZone = $this->subZoneFactory->create();
            $subZone->load($id);
            $subZone
                ->setData($subZoneData)
                ->save();

            return $resultRedirect->setPath('*/*/index');
        }
    }
}