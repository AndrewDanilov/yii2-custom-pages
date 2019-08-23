<?php
namespace andrewdanilov\custompages\models;

use yii\db\ActiveRecord;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use andrewdanilov\gridtools\behaviors\DateBehavior;

/**
 * This is the model class for table "page".
 *
 * @property int $id
 * @property int $category_id
 * @property string $slug
 * @property string $image
 * @property string $title
 * @property string $text
 * @property string $albums
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
	        [['albums'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category',
            'slug' => 'Slug',
            'image' => 'Cover',
            'title' => 'Title',
            'text' => 'Text',
	        'albums' => 'Albums',
            'published_at' => 'Published',
            'meta_title' => 'Meta Title',
            'meta_description' => 'Meta Description',
        ];
    }

    public function getCategory()
    {
    	return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

	public function afterFind()
	{
		parent::afterFind();
		if (!is_array($this->albums)) {
			if ($this->albums) {
				$this->albums = json_decode($this->albums, true);
			} else {
				$this->albums = [];
			}
		}
	}

	public function beforeSave($insert)
	{
		if (is_array($this->albums)) {
			$albums = $this->albums;
			if (isset($albums['blankid'])) {
				unset($albums['blankid']);
			}
			$this->albums = json_encode($albums);
		}
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
