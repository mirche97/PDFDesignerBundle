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
class ShoplineBundleInstaller implements Installation {

    /**
     * {@inheritdoc}
     */
    public function getMigrationVersion() {
        return 'v1_5';
    }

    /**
     * @inheritdoc
     */
    public function up(Schema $schema, QueryBag $queries) {

         $this->shoplineTemplate($schema);
         $this->shoplineTemplateForeignKeys($schema);
        $this->shoplineTemplateTranslate($schema);
        $this->shoplineTemplateTranslationForeignKeys($schema);
        //$this->rename_designer_template_translate($schema,$queries);
    }

    protected function shoplineTemplate(Schema $schema) {
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

    protected function shoplineTemplateForeignKeys($schema) {
        $table = $schema->getTable('shopline_designer_template');
        $table->addForeignKeyConstraint($schema->getTable('oro_user'), ['user_owner_id'], ['id'], ['onDelete' => 'CASCADE', 'onUpdate' => null]);
        $table->addForeignKeyConstraint($schema->getTable('oro_organization'), ['organization_id'], ['id'], ['onDelete' => 'CASCADE', 'onUpdate' => null]);
    }

    protected function shoplineTemplateTranslate(Schema $schema) {
        $table = $schema->createTable('designer_template_translate');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('object_id', 'integer', ['notnull' => false]);
        $table->addColumn('locale', 'string', ['length' => 8]);
        $table->addColumn('field', 'string', ['length' => 32]);
        $table->addColumn('content', 'text', ['notnull' => false]);
        $table->setPrimaryKey(['id']);
        
    }

    /**
     * Generate foreign keys for table shopline_designer_template_translation
     *
     * @param Schema $schema
     */
    protected function shoplineTemplateTranslationForeignKeys(Schema $schema) {
        $table = $schema->getTable('designer_template_translate');
        $table->addForeignKeyConstraint(
                $schema->getTable('shopline_designer_template'), ['object_id'], ['id'], ['onDelete' => 'CASCADE', 'onUpdate' => null]
        );
    }
    
}
