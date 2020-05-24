<?php

use yii\db\Migration;

/**
 * Class m200411_032200_category_order
 */
class m200411_032200_category_order extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		if ($this->getDb()->getSchema()->getTableSchema('page_category')->getColumn('order') === null) {
			$this->addColumn('page_category', 'order', $this->integer()->notNull()->defaultValue(0));
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropColumn('page_category', 'order');
	}
}
