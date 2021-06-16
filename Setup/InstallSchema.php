<?php
namespace Webline\Donation\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class InstallSchema
 * @package Webline\Donation\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * Base donate fee
     */
    CONST BASE_DONATE_FEE = 'base_pp_donate_fee';

    /**
     * Donate fee
     */
    CONST DONATE_FEE = 'pp_donate_fee';

    /**
     * @var array
     */
    private $tablesName = [
        'quote',
        'quote_address',
        'quote_item',
        'sales_order',
        'sales_invoice',
        'sales_creditmemo'
    ];

    /**
     * {@inheritdoc}
     *
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        foreach ( $this->tablesName as $tableName ) {

            $setup->getConnection()
                ->addColumn(
                    $setup->getTable($tableName),
                    self::BASE_DONATE_FEE,
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                        'nullable' => true,
                        'length' => '12,4',
                        'default' => '0.0000',
                        'comment' => 'Base Donate Fee'
                    ]
                );

            $setup->getConnection()
                ->addColumn(
                    $setup->getTable($tableName),
                    self::DONATE_FEE,
                    [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                        'nullable' => true,
                        'length' => '12,4',
                        'default' => '0.0000',
                        'comment' => 'Donate Fee'
                    ]
                );

        }

        $installer->endSetup();
    }
}
