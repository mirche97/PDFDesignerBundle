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
        
        $table = $schema->createTable('test_installation_table');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('field', 'string', ['length' => 500]);
        $table->setPrimaryKey(['id']);
       /*  $this->renameExtension->renameTable(
            $schema,
            $queries,
            'test_installation_table',
            'test_installation_table2'
        );
        $queries->addQuery("
                    CREATE TABLE IF NOT EXISTS `shopline_designer_template` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `user_owner_id` int(11) DEFAULT NULL,
                      `organization_id` int(11) DEFAULT NULL,
                      `definition` longtext COLLATE utf8_unicode_ci NOT NULL,
                      `isSystem` tinyint(1) NOT NULL,
                      `isEditable` tinyint(1) NOT NULL,
                      `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                      `parent` int(11) DEFAULT NULL,
                      `header` longtext COLLATE utf8_unicode_ci,
                      `content` longtext COLLATE utf8_unicode_ci,
                      `style_content` longtext COLLATE utf8_unicode_ci,
                      `footer` longtext COLLATE utf8_unicode_ci,
                      `entityName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                      `created_at` datetime DEFAULT NULL,
                      `updated_at` datetime DEFAULT NULL,
                      `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
                      PRIMARY KEY (`id`),
                      UNIQUE KEY `UQ_NAME` (`name`,`entityName`),
                      KEY `IDX_911F65179EB185F9` (`user_owner_id`),
                      KEY `IDX_911F651732C8A3DE` (`organization_id`),
                      KEY `designer_name_idx` (`name`),
                      KEY `designer_is_system_idx` (`isSystem`),
                      KEY `designer_entity_name_idx` (`entityName`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

            ");
           
        $queries->addQuery(
                "CREATE TABLE IF NOT EXISTS `shopline_designer_template_translation` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `object_id` int(11) DEFAULT NULL,
                      `locale` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
                      `field` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
                      `content` longtext COLLATE utf8_unicode_ci,
                      PRIMARY KEY (`id`),
                      KEY `IDX_B89C4580232D562B` (`object_id`),
                      KEY `lookup_unique_idx` (`locale`,`object_id`,`field`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
                   "
        );
          $queries->addQuery("ALTER TABLE `shopline_designer_template`
  ADD CONSTRAINT `FK_911F651732C8A3DE` FOREIGN KEY (`organization_id`) REFERENCES `oro_organization` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_911F65179EB185F9` FOREIGN KEY (`user_owner_id`) REFERENCES `oro_user` (`id`) ON DELETE SET NULL;
");
        $queries->addQuery("ALTER TABLE `shopline_designer_template_translation`
                                ADD CONSTRAINT `FK_B89C4580232D562B` FOREIGN KEY (`object_id`) REFERENCES `shopline_designer_template` (`id`) ON DELETE CASCADE;
                            ");*/
    }
    
    /**
     * Create oro_dashboard_widget_state table
     *
     * @param Schema $schema
     */
    protected function createshopline_designer_templateTable(Schema $schema)
    {
        $table = $schema->createTable('shopline_designer_template');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('user_owner_id', 'integer', ['notnull' => false]);
        $table->addColumn('organization_id', 'integer', ['notnull' => false]);
        $table->addColumn('isSystem', 'boolean', []);
        $table->addColumn('isEditable', 'boolean', []);
        $table->addColumn('name', 'string', ['length' => 255]);
        $table->addColumn('parent', 'integer', ['notnull' => true]);

        $table->addColumn('parent', 'integer', ['notnull' => true]);
        $table->addColumn('content', 'longtext');
        $table->addColumn('style_content', 'longtext');
        $table->addColumn('footer', 'longtext');
        $table->addColumn('entityName', 'string', ['length' => 255]);
        $table->addColumn('created_at', 'datetime', ['notnull' => true]);
        $table->addColumn('updated_at', 'datetime', ['notnull' => true]);
        $table->addColumn('`type`', 'string', ['length' => 20]);
        $table->addColumn('parent', 'integer', ['notnull' => true]);
        
        $table->addIndex(['user_owner_id'], 'idx_4b4f5f879eb185f9', []);

        $table->setPrimaryKey(['id']);
    }
    
    

}
