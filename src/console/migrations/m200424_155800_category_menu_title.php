<?php

use yii\db\Migration;

/**
 * Class m200424_155800_category_menu_title
 */
class m200424_155800_category_menu_title extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->addColumn('page_category', 'menu_title', $this->string());
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropColumn('page_category', 'menu_title');
	}
}
