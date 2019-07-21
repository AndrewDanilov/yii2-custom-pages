<?php
namespace andrewdanilov\custompages\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "page".
 *
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property string $text
 * @property string $category_template
 * @property string $pages_template
 * @property string $meta_title
 * @property string $meta_description
 * @property Page[] $pages
 */
class Category extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'page_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slug', 'title', 'category_template', 'pages_template'], 'required'],
            [['text'], 'string'],
            [['slug', 'title', 'category_template', 'pages_template', 'meta_title', 'meta_description'], 'string', 'max' => 255],
            [['slug'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'ЧПУ категории',
            'title' => 'Заголовок',
            'text' => 'Текст',
            'category_template' => 'Шаблон категории',
            'pages_template' => 'Шаблон страниц',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
        ];
    }

    public function getPages()
    {
    	return $this->hasMany(Page::class, ['category_id' => 'id']);
    }

    public static function getCategoriesList()
    {
    	return static::find()->select(['title', 'id'])->orderBy('title')->indexBy('id')->column();
    }
}
