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
		if ($this->getDb()->getSchema()->getTableSchema('page')->getColumn('hide_category_slug') !== null) {
			$this->dropColumn('page', 'hide_category_slug');
		}
		if ($this->getDb()->getSchema()->getTableSchema('page')->getColumn('albums') === null) {
			$this->addColumn('page', 'albums', $this->text());
		}
		if ($this->getDb()->getSchema()->getTableSchema('page')->getColumn('is_main') === null) {
			$this->addColumn('page', 'is_main', $this->tinyInteger()->notNull()->defaultValue(0));
		}
		$this->alterColumn('page', 'category_id', $this->integer()->notNull()->defaultValue(0));
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->alterColumn('page', 'category_id', $this->integer()->notNull());
	}
}
