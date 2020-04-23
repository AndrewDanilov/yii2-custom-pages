<?php

use yii\db\Migration;

/**
 * Class m200424_002800_page_modify_fields
 */
class m200424_002800_page_modify_fields extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->dropColumn('page', 'hide_category_slug');
		$this->alterColumn('page', 'category_id', $this->integer()->notNull()->defaultValue(0));
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->addColumn('page', 'hide_category_slug', $this->tinyInteger()->notNull()->defaultValue(0));
		$this->alterColumn('page', 'category_id', $this->integer()->notNull());
	}
}
