<?php

use yii\db\Migration;

/**
 * Class m200412_161400_page_source
 */
class m200412_161400_page_source extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->addColumn('page', 'source', $this->string());
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropColumn('page', 'source');
	}
}
