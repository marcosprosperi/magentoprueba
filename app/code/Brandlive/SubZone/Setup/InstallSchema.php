<?php
namespace Brandlive\SubZone\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;


class InstallSchema implements InstallSchemaInterface
{
    /**
     * @version 0.0.1
     * @param SchemaSetupInterface   $setup
     * @param ModuleContextInterface $context
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    )
    {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('brandlive_subzone')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('brandlive_subzone')
            )
                ->addColumn(
                    'subzone_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                        'unsigned' => true,
                    ],
                    'SubZone ID'
                )
                ->addColumn(
                    'store_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [ 'identity' => false, 'unsigned' => true, 'nullable' => false, 'default' => 0, 'primary' => false],
                    'Store views'
                )
                ->addColumn(
                    'name',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    100,
                    ['nullable => false'],
                    'SubZone Name'
                )
                ->addColumn(
                    'postal_codes',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    1000,
                    ['nullable => true'],
                    'SubZone PostalCodes'
                )
                ->addIndex(
                    $installer->getIdxName('brandlive_subzone', ['subzone_id']),
                    ['subzone_id']
                )
                ->setComment('SubZone Table');
                $installer->getConnection()->createTable($table);
        }
       
        //Add subzone_id,store_pickup,car_pickup to pointofsale table
        $tableName = $installer->getTable('pointofsale'); 
        if ($installer->getConnection()->isTableExists($tableName) == true) {
               $installer->getConnection()
               ->addColumn(
                  $tableName,
                  'subzone_id',
                  ['type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,'LENGTH'=>255,'nullable' => false, 'after' => 'place_id','comment' => 'SubZone ID']
               );
               $installer->getConnection()
               ->addColumn(
                    $tableName,
                    'store_pickup',
                    ['type' => \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,'nullable' => true, 'after' => 'stock_status_message','comment' => 'Enable Store Pickup']
               );
               $installer->getConnection()
               ->addColumn(
                    $tableName,
                    'car_pickup',
                    ['type' => \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,'nullable' => true, 'after' => 'store_pickup','comment' => 'Enable Car Pickup']
               );
        }
        $installer->endSetup();
    }
}
