<?php

namespace Shopline\Bundle\PDFDesignerBundle\Migrations\Schema;

use Doctrine\DBAL\Schema\Schema;

use Oro\Bundle\MigrationBundle\Migration\Installation;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

use Shopline\Bundle\PDFDesignerBundle\Migrations\Schema\v1_5\DesignerBundle;

/**
 * @SuppressWarnings(PHPMD.TooManyMethods)
 * @SuppressWarnings(PHPMD.ExcessiveClassLength)
 */
class ShoplineBundleInstaller implements Installation
{
    /**
     * {@inheritdoc}
     */
    public function getMigrationVersion()
    {
        return 'v1_5';
    }
    /**
     * @inheritdoc
     */
    public function up(Schema $schema, QueryBag $queries)
    { 
         $table = $schema->createTable('test_installation_table');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('field', 'string', ['length' => 500]);
        $table->setPrimaryKey(['id']);
        $table = $schema->createTable('shopline_designer_template');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('user_owner_id', 'integer', []);
        $table->addColumn('organization_id', 'integer', []);
        $table->addColumn('definition', 'text', []);
        $table->addColumn('isSystem', 'smallint', ['length' => 1]);
        $table->addColumn('isEditable', 'smallint', ['length' => 1]);
        $table->addColumn('name', 'string', ['length' => 255]);
        $table->addColumn('parent', 'integer', []);
        $table->addColumn('header', 'text', ['notnull' => false]);
        $table->addColumn('content', 'text', ['notnull' => false]);
        $table->addColumn('style_content', 'text', ['notnull' => false]);
        $table->addColumn('footer', 'text', ['notnull' => false]);
        $table->addColumn('entityName', 'string', ['length' => 255]);
        $table->addColumn('created_at', 'datetime', []);
        $table->addColumn('updated_at', 'datetime', []);
        $table->addColumn('type', 'string', ['length' => 20]);
        $table->setPrimaryKey(['id']);
        //$table->addUniqueIndex(['user_owner_id', 'organization_id'], 'unique_idx');
    //    $table->addIndex(['user_owner_id'], 'IDX_AB2BC195A76ED395', []);
        /** End of generate table oro_sidebar_state **/

        /** Generate table oro_sidebar_widget **/
        $table = $schema->createTable('shopline_designer_template_translation');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('object_id', 'integer', []);
        $table->addColumn('locale', 'string', ['length' => 8]);
        $table->addColumn('field', 'string', ['length' => 50]);
        $table->addColumn('content', 'text', ['notnull' => false]);
        $table->setPrimaryKey(['id']);
    }
}
