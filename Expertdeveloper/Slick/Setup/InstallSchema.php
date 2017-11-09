<?php
namespace Expertdeveloper\Slick\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        if (!$installer->tableExists('expertdeveloper_slick')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('expertdeveloper_slick'))
                ->addColumn(
                    'contact_id',
                    Table::TYPE_INTEGER,
                    10,
                    ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true]
                )
                ->addColumn('contact_name', Table::TYPE_TEXT, 255, ['nullable' => false])
				->addColumn('categories', Table::TYPE_TEXT, 255, ['nullable' => true])
				->addColumn('center_image_width', Table::TYPE_TEXT, 255, ['nullable' => true])
				->addColumn('thumbnail_width', Table::TYPE_TEXT, 255, ['nullable' => true])
				->addColumn('arrows_top', Table::TYPE_TEXT, 255, ['nullable' => true])
				->addColumn('text_bottom', Table::TYPE_TEXT, 255, ['nullable' => true])
                ->addColumn('creation_time', Table::TYPE_DATETIME, null, ['nullable' => false], 'Creation Time')
                ->addColumn('update_time', Table::TYPE_DATETIME, null, ['nullable' => false], 'Update Time')
                ->setComment('Sample table');

            $installer->getConnection()->createTable($table);
        }

        if (!$installer->tableExists('expertdeveloper_product_attachment_rel')) {
            $table = $installer->getConnection()
                ->newTable($installer->getTable('expertdeveloper_product_attachment_rel'))
                ->addColumn('contact_id', Table::TYPE_INTEGER, 10, ['nullable' => false, 'unsigned' => true])
                ->addColumn('product_id', Table::TYPE_INTEGER, 10, ['nullable' => false, 'unsigned' => true], 'Magento Product Id')
                ->addForeignKey(
                    $installer->getFkName(
                        'expertdeveloper_slick',
                        'contact_id',
                        'expertdeveloper_product_attachment_rel',
                        'contact_id'
                    ),
                    'contact_id',
                    $installer->getTable('expertdeveloper_slick'),
                    'contact_id',
                    Table::ACTION_CASCADE
                )
                ->addForeignKey(
                    $installer->getFkName(
                        'expertdeveloper_product_attachment_rel',
                        'contact_id',
                        'catalog_product_entity',
                        'entity_id'
                    ),
                    'product_id',
                    $installer->getTable('catalog_product_entity'),
                    'entity_id',
                    Table::ACTION_CASCADE
                )
                ->setComment('Expertdeveloper Product Attachment relation table');

            $installer->getConnection()->createTable($table);
        }

        $installer->endSetup();
    }
}
