<?php

namespace Wyomind\AdvancedInventory\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{

    public function upgrade(
    SchemaSetupInterface $setup,
            ModuleContextInterface $context
    )
    {

        $installer = $setup;
        $installer->startSetup();

        if (version_compare($context->getVersion(), '6.2.0') < 0) {
            $installer->getConnection()->addColumn(
                    $installer->getTable('pointofsale'), 'stock_status_message', "varchar(255) DEFAULT NULL"
            );
        }
        
        if (version_compare($context->getVersion(), '6.3.0') < 0) {
            $quoteItem = 'quote_item';
            $salesOrderItem = 'sales_order_item';
            // quote
            $setup->getConnection("checkout")
                    ->addColumn(
                            $setup->getTable($quoteItem), 'pre_assignation', [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        'length' => 5,
                        'comment' => 'Item pre assignation'
                            ]
            );
            // quote
            $setup->getConnection("sales")
                    ->addColumn(
                            $setup->getTable($salesOrderItem), 'pre_assignation', [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        'length' => 5,
                        'comment' => 'Item pre assignation'
                            ]
            );
        }

        $installer->endSetup();
    }

}
