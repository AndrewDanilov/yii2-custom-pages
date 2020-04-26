<?php

use yii\db\Migration;

/**
 * Class m200426_115300_category_modify_fields
 */
class m200426_115300_category_modify_fields extends Migration
{
	/**
	 * {@inheritdoc}
	 */
	public function safeUp()
	{
		$this->dropIndex('slug', 'page_category');
		$this->createIndex(
			'ux_page_category_parent_id_slug',
			'page_category',
			['parent_id', 'slug'],
			true
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown()
	{
		$this->dropIndex('ux_page_category_parent_id_slug', 'page_category');
		$this->createIndex(
			'slug',
			'page_category',
			'slug'
		);
	}
}
