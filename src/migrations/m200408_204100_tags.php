<?php

use yii\db\Migration;

/**
 * Class m200408_204100_init
 */
class m200408_204100_tags extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
	    $tableOptions = null;
	    if ($this->db->driverName === 'mysql') {
		    $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
	    }

	    $this->createTable('page_tag', [
	    	'id' => $this->primaryKey(),
		    'slug' => $this->string()->unique(),
		    'name' => $this->string(),
		    'meta_title' => $this->string(),
		    'meta_description' => $this->string(),
	    ], $tableOptions);

	    $this->createTable('page_tag_ref', [
		    'id' => $this->primaryKey(),
		    'page_id' => $this->integer()->notNull(),
		    'tag_id' => $this->integer()->notNull(),
	    ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('page_tag');
        $this->dropTable('page_tags');
    }
}
