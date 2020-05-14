<?php

use yii\db\Migration;

/**
 * Class m200514_131100_page_template
 */
class m200514_131100_page_template extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->addColumn('page', 'page_template', $this->string());
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropColumn('page', 'page_template');
	}
}
