<?php
namespace andrewdanilov\custompages\common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Query;
use yii\helpers\Inflector;
use andrewdanilov\custompages\frontend\Module;
use andrewdanilov\behaviors\DateBehavior;
use andrewdanilov\behaviors\TagBehavior;
use andrewdanilov\helpers\TextHelper;

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
 * @property string $page_template
 * @property string $fields_data
 * @property Category $category
 * @property string $shortText
 * @property string $processedText
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
				'referenceModelClass' => 'andrewdanilov\custompages\common\models\PageTagRef',
				'referenceModelAttribute' => 'page_id',
				'referenceModelTagAttribute' => 'tag_id',
				'tagModelClass' => 'andrewdanilov\custompages\common\models\PageTag',
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
            [['slug', 'title', 'meta_title', 'meta_description', 'source', 'page_template'], 'string', 'max' => 255],
	        [['slug'], 'unique', 'targetAttribute' => ['category_id', 'slug'], 'message' => Yii::t('custompages/page', 'That page slug is already used within selected category')],
	        [['albums', 'fields_data'], 'safe'],
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
            'category_id' => Yii::t('custompages/page', 'Category'),
            'slug' => Yii::t('custompages/page', 'Slug'),
            'image' => Yii::t('custompages/page', 'Cover'),
            'title' => Yii::t('custompages/page', 'Title'),
            'text' => Yii::t('custompages/page', 'Text'),
	        'albums' => Yii::t('custompages/page', 'Albums'),
            'published_at' => Yii::t('custompages/page', 'Published'),
            'is_main' => Yii::t('custompages/page', 'Main'),
            'meta_title' => Yii::t('custompages/page', 'Meta Title'),
            'meta_description' => Yii::t('custompages/page', 'Meta Description'),
            'tagIds' => Yii::t('custompages/page', 'Tags'),
            'source' => Yii::t('custompages/page', 'Source'),
            'page_template' => Yii::t('custompages/page', 'Page Template'),
            'fields_data' => Yii::t('custompages/page', 'Custom Fields'),
        ];
    }

    public function getCategory()
    {
    	return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

	public function getProcessedText()
	{
		$pageTextProcessor = Module::getInstance()->pageTextProcessor;
		if (!empty($pageTextProcessor) && is_callable($pageTextProcessor)) {
			return call_user_func($pageTextProcessor, $this->text);
		}
		return $this->text;
	}

	public function afterFind()
	{
		if (!is_array($this->albums)) {
			if ($this->albums) {
				$this->albums = json_decode($this->albums, true);
			} else {
				$this->albums = [];
			}
		}
        if (!is_array($this->fields_data)) {
            if ($this->fields_data) {
                $this->fields_data = json_decode($this->fields_data, true);
            } else {
                $this->fields_data = [];
            }
        }
		parent::afterFind();
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
		if (is_array($this->fields_data)) {
			$this->fields_data = json_encode($this->fields_data);
		}
		if (!$this->slug) {
			$this->slug = Inflector::slug($this->title);
		}
		if (!$this->published_at || !strtotime($this->published_at)) {
			$this->published_at = date('d.m.Y');
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

    public function afterSave($insert, $changedAttributes)
    {
        if (!is_array($this->albums)) {
            if ($this->albums) {
                $this->albums = json_decode($this->albums, true);
            } else {
                $this->albums = [];
            }
        }
        if (!is_array($this->fields_data)) {
            if ($this->fields_data) {
                $this->fields_data = json_decode($this->fields_data, true);
            } else {
                $this->fields_data = [];
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }

    public function getShortText()
    {
		return TextHelper::shortText($this->processedText, Module::getInstance()->pageShortTextWordsCount);
	}

    public function getField($name)
    {
    	if (is_array($this->fields_data) && isset($this->fields_data[$name])) {
            return $this->fields_data[$name];
        }
        return '';
    }

    private function hasField($name)
    {
        return is_array($this->fields_data) && isset($this->fields_data[$name]);
    }

    public function getFieldType($name)
    {
    	$category = $this->category;
        if ($category && is_array($category->pages_fields)) {
            foreach ($category->pages_fields as $pages_field) {
                if (isset($pages_field['name']) && $pages_field['name'] == $name) {
                    return $pages_field['type'] ?? 'string';
                }
            }
        }
        return false;
    }
}
