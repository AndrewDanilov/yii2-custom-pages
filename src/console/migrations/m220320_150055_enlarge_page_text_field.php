<?php

use yii\db\Migration;

/**
 * Class m220320_150055_enlarge_page_text_field
 */
class m220320_150055_enlarge_page_text_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
	    $this->alterColumn('page', 'text', $this->getDb()->getSchema()->createColumnSchemaBuilder('mediumtext'));
	    $this->alterColumn('page_category', 'text', $this->getDb()->getSchema()->createColumnSchemaBuilder('mediumtext'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
	    $this->alterColumn('page', 'text', $this->text());
	    $this->alterColumn('page_category', 'text', $this->text());
    }
}
