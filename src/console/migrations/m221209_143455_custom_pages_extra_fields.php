<?php

use yii\db\Migration;

/**
 * Class m221209_143455_custom_pages_extra_fields
 */
class m221209_143455_custom_pages_extra_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%page_category}}', 'pages_fields', $this->text());
        $this->addColumn('{{%page}}', 'fields_data', $this->getDb()->getSchema()->createColumnSchemaBuilder('mediumtext'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%page_category}}', 'pages_fields');
        $this->dropColumn('{{%page}}', 'fields_data');
    }
}
