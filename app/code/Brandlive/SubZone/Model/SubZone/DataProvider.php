<?php
namespace Brandlive\SubZone\Model\SubZone;
use Brandlive\SubZone\Model\ResourceModel\SubZone\CollectionFactory;
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

   /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $subZoneCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $subZoneCollectionFactory,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
        
    ) {
        $this->collection = $subZoneCollectionFactory->create();
        $this->dataPersistor=$dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        $this->loadedData = array();

        foreach ($items as $subZone) {
            $this->loadedData[$subZone->getId()]['subzone'] = $subZone->getData();
        }

        $data = $this->dataPersistor->get('subzone_manage');
        if (!empty($data)) {
            $subZone = $this->collection->getNewEmptyItem();
            $subZone->setData($data);
            $this->loadedData[$subZone->getId()]['subzone'] = $subZone->getData();
            $this->dataPersistor->clear('subzone_manage');
        }
        
        return $this->loadedData;

    }
}