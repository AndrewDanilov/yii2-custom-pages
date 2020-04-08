<?php
namespace andrewdanilov\custompages\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\Inflector;

/**
 * Class PageTag
 *
 * @property $id int
 * @property $slug string
 * @property $name string
 * @property $meta_title string
 * @property $meta_description string
 * @package andrewdanilov\custompages\models
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

	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'slug' => Yii::t('custompages/backend/tag', 'Slug'),
			'name' => Yii::t('custompages/backend/tag', 'Name'),
			'meta_title' => Yii::t('custompages/backend/tag', 'Meta Title'),
			'meta_description' => Yii::t('custompages/backend/tag', 'Meta Description'),
		];
	}

	public function beforeSave($insert)
	{
		if (!$this->slug) {
			$this->slug = Inflector::slug($this->name);
		}
		return parent::beforeSave($insert);
	}
}