<?php

namespace Shopline\Bundle\PDFDesignerBundle\Migrations\Schema\v1_5;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;
use Oro\Bundle\MigrationBundle\Migration\Extension\RenameExtension;
use Oro\Bundle\MigrationBundle\Migration\Extension\RenameExtensionAwareInterface;


class DesignerBundle implements Migration, RenameExtensionAwareInterface
{
    /**
     * {@inheritdoc}
     */
    /**
     * @var RenameExtension
     */
    protected $renameExtension;

    /**
     * @inheritdoc
     */
    public function setRenameExtension(RenameExtension $renameExtension)
    {
        $this->renameExtension = $renameExtension;
    }

    /**
     * @inheritdoc
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        $table = $schema->createTable('test_table');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('created', 'datetime', []);
        $table->addColumn('field', 'string', ['length' => 500]);
        $table->addColumn('another_field', 'string', ['length' => 255]);
        $table->setPrimaryKey(['id']);

        $this->renameExtension->renameTable(
            $schema,
            $queries,
            'old_table_name',
            'new_table_name'
        );
        $queries->addQuery(
            "ALTER TABLE another_table ADD COLUMN test_column INT NOT NULL"
        );
    }
}