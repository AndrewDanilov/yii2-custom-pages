<?php
namespace andrewdanilov\custompages\models;

use yii\db\ActiveRecord;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use andrewdanilov\custompages\behaviors\DateBehavior;

/**
 * This is the model class for table "page".
 *
 * @property int $id
 * @property int $category_id
 * @property string $slug
 * @property string $image
 * @property string $title
 * @property string $text
 * @property string $published_at
 * @property string $meta_title
 * @property string $meta_description
 * @property Category $category
 * @property string $shortText
 */
class Page extends ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			[
				'class' => DateBehavior::class,
				'dateAttributes' => [
					'published_at' => DateBehavior::DATE_FORMAT,
				],
			],
		];
	}

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'page';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
        	[['title', 'category_id'], 'required'],
            [['image', 'text', 'published_at'], 'string'],
            [['category_id'], 'integer'],
            [['slug', 'title', 'meta_title', 'meta_description'], 'string', 'max' => 255],
	        [['slug'], 'unique', 'targetAttribute' => ['category_id', 'slug']],
	        [['published_at'], 'default', 'value' => date('d.m.Y')],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Категория',
            'slug' => 'ЧПУ страницы',
            'image' => 'Обложка',
            'title' => 'Заголовок',
            'text' => 'Текст',
            'published_at' => 'Опубликовано',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
        ];
    }

    public function getCategory()
    {
    	return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

	public function beforeSave($insert)
	{
		if (!$this->slug) {
			$this->slug = Inflector::slug($this->title);
		}
		return parent::beforeSave($insert);
	}

	public function getShortText()
	{
		return StringHelper::truncateWords($this->text, 50, '...', true);
	}
}
