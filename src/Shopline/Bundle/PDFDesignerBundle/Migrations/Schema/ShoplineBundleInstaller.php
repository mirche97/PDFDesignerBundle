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
        //$this->install_shopline_designer_template_translation($schema);
        $this->install_shopline_designer_template($schema);
        $this->addForeignKey_shopline_designer_template($schema);
    }
    
    protected function install_shopline_designer_template(Schema $schema){
        $table = $schema->createTable('shopline_designer_template');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('user_owner_id', 'integer', ['notnull' => false]);
        $table->addColumn('organization_id', 'integer', ['notnull' => false]);
        $table->addColumn('definition', 'text', ['notnull' => false]);
        $table->addColumn('isSystem', 'smallint', ['length' => 1]);
        $table->addColumn('isEditable', 'smallint', ['length' => 1]);
        $table->addColumn('name', 'string', ['length' => 255]);
        $table->addColumn('parent', 'integer', ['notnull' => false]);
        $table->addColumn('header', 'text', ['notnull' => false]);
        $table->addColumn('content', 'text', ['notnull' => false]);
        $table->addColumn('style_content', 'text', ['notnull' => false]);
        $table->addColumn('footer', 'text', ['notnull' => false]);
        $table->addColumn('entityName', 'string', ['length' => 255]);
        $table->addColumn('created_at', 'datetime', ['notnull' => false]);
        $table->addColumn('updated_at', 'datetime', ['notnull' => false]);
        $table->addColumn('type', 'string', ['length' => 20]);
        $table->addIndex(['organization_id'], 'idx_b48821b632c8a3ded', []);
        $table->setPrimaryKey(['id']);
    }
    
    protected function addForeignKey_shopline_designer_template($schema){
        $table = $schema->getTable('shopline_designer_template');
        $table->addForeignKeyConstraint($schema->getTable('oro_user'), ['user_owner_id'], ['id'], ['onDelete' => 'CASCADE', 'onUpdate' => null]);
        $table->addForeignKeyConstraint($schema->getTable('oro_organization'), ['organization_id'], ['id'], ['onDelete' => 'CASCADE', 'onUpdate' => null]);
       
    }
    protected function install_shopline_designer_template_translation(Schema $schema){
        $table = $schema->createTable('shopline_designer_template_translation');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('object_id', 'integer', ['notnull' => false]);
        $table->addColumn('locale', 'string', ['length' => 8]);
        $table->addColumn('field', 'string', ['length' => 50]);
        $table->addColumn('content', 'text', ['notnull' => false]);
        $table->setPrimaryKey(['id']);
    }
    
}
