<?php
namespace Brandlive\SubZone\Controller\Adminhtml\Manage;
use Magento\Backend\App\Action;
use Magento\Ui\Component\MassAction\Filter;


class MassDelete extends \Magento\Backend\App\Action
{

    /**
     * @var CollectionFactory
     */
    protected $subZoneCollectionFactory;

    /**
     * @var Filter
     */
    protected $filter;

    public function __construct(
        Action\Context $context,
        \Brandlive\SubZone\Model\ResourceModel\SubZone\CollectionFactory $subZoneCollectionFactory,
        Filter $filter
    ) {
        $this->subZoneCollectionFactory = $subZoneCollectionFactory;
        $this->filter=$filter;

        parent::__construct($context);
    }

    public function execute()
    {

        $collection = $this->filter->getCollection($this->subZoneCollectionFactory->create());
        $subZonesDeletes=0;
        foreach ($collection->getItems() as $item) {
            $item->delete();
            $subZonesDeletes++;
        }
        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $subZonesDeletes));

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/index', array('_current' => true));
    }
}