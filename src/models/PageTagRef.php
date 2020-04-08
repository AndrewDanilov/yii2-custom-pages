<?php
namespace andrewdanilov\custompages\models;

use yii\db\ActiveRecord;

/**
 * Class PageTagRef
 *
 * @property $id int
 * @property $page_id int
 * @property $tag_id int
 * @package andrewdanilov\custompages\models
 */
class PageTagRef extends ActiveRecord
{
	public static function tableName()
	{
		return 'page_tag_ref';
	}

	public function getPage()
	{
		return $this->hasOne(Page::class, ['id' => 'page_id']);
	}

	public function getTag()
	{
		return $this->hasOne(PageTag::class, ['id' => 'tag_id']);
	}
}