<?php
namespace andrewdanilov\custompages\common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;

/**
 * Class PageTag
 *
 * @property $id int
 * @property $slug string
 * @property $name string
 * @property $meta_title string
 * @property $meta_description string
 * @property $pages Page[]
 * @package andrewdanilov\custompages\common\models
 */
class PageTag extends ActiveRecord
{
	public static function tableName()
	{
		return 'page_tag';
	}

	public function rules()
	{
		return [
			[['name'], 'required'],
			[['slug', 'name', 'meta_title', 'meta_description'], 'string', 'max' => 255],
			[['slug'], 'unique'],
		];
	}

	public function getPages()
	{
		return $this->hasMany(Page::class, ['id' => 'page_id'])->viaTable(PageTagRef::tableName(), ['tag_id' => 'id'])->orderBy(['published_at' => SORT_DESC, 'id' => SORT_DESC]);
	}

	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'slug' => Yii::t('custompages/page-tag', 'Slug'),
			'name' => Yii::t('custompages/page-tag', 'Name'),
			'meta_title' => Yii::t('custompages/page-tag', 'Meta Title'),
			'meta_description' => Yii::t('custompages/page-tag', 'Meta Description'),
		];
	}

	public function beforeSave($insert)
	{
		if (!$this->slug) {
			$this->slug = Inflector::slug($this->name);
		}
		return parent::beforeSave($insert);
	}

	public static function getAllTags()
	{
		return self::find()->all();
	}
}