<?php
namespace andrewdanilov\custompages\models;

use andrewdanilov\helpers\TextHelper;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use andrewdanilov\behaviors\DateBehavior;
use andrewdanilov\behaviors\TagBehavior;
use andrewdanilov\custompages\Module as CustomPages;

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
 * @property boolean $is_main
 * @property string $meta_title
 * @property string $meta_description
 * @property string $source
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
					'published_at' => DateBehavior::DATE_FORMAT_AUTO,
				],
			],
			[
				'class' => TagBehavior::class,
				'referenceModelClass' => 'andrewdanilov\custompages\models\PageTagRef',
				'referenceModelAttribute' => 'page_id',
				'referenceTagModelAttribute' => 'tag_id',
				'tagModelClass' => 'andrewdanilov\custompages\models\PageTag',
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
        	[['title'], 'required'],
            [['image', 'text', 'published_at'], 'string'],
            [['category_id'], 'integer'],
            [['category_id'], 'default', 'value' => 0],
            [['slug', 'title', 'meta_title', 'meta_description', 'source'], 'string', 'max' => 255],
	        [['slug'], 'unique', 'targetAttribute' => ['category_id', 'slug']],
	        [['published_at'], 'default', 'value' => date('d.m.Y')],
	        [['albums'], 'safe'],
	        [['is_main'], 'boolean'],
	        [['is_main'], 'default', 'value' => 0],
	        [['tagIds'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => Yii::t('custompages/backend/page', 'Category'),
            'slug' => Yii::t('custompages/backend/page', 'Slug'),
            'image' => Yii::t('custompages/backend/page', 'Cover'),
            'title' => Yii::t('custompages/backend/page', 'Title'),
            'text' => Yii::t('custompages/backend/page', 'Text'),
	        'albums' => Yii::t('custompages/backend/page', 'Albums'),
            'published_at' => Yii::t('custompages/backend/page', 'Published'),
            'is_main' => Yii::t('custompages/backend/page', 'Main'),
            'meta_title' => Yii::t('custompages/backend/page', 'Meta Title'),
            'meta_description' => Yii::t('custompages/backend/page', 'Meta Description'),
            'tagIds' => Yii::t('custompages/backend/page', 'Tags'),
            'source' => Yii::t('custompages/backend/page', 'Source'),
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
		$pageTextFilter = CustomPages::getInstance()->pageTextFilter;
		if (!empty($pageTextFilter) && is_callable($pageTextFilter)) {
			$this->text = call_user_func($pageTextFilter, $this->text);
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
		if ($this->is_main) {
			// drop all other is_main pages setting
			(new Query())->createCommand()
				->update(Page::tableName(), [
					'is_main' => 0,
				], ['not', ['id' => $this->id]])->execute();
		}
		return parent::beforeSave($insert);
	}

	public function getShortText()
	{
		return TextHelper::shortText($this->text, CustomPages::getInstance()->pageShortTextWordsCount);
	}
}
