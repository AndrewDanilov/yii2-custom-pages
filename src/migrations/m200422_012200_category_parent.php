<?php

use yii\db\Migration;

/**
 * Class m200422_012200_category_parent
 */
class m200422_012200_category_parent extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->addColumn('page_category', 'parent_id', $this->integer()->unsigned()->notNull()->defaultValue(0));
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropColumn('page_category', 'parent_id');
	}
}
