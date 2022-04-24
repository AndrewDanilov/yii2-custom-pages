<?php
namespace andrewdanilov\custompages\common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;
use andrewdanilov\custompages\frontend\Module;

/**
 * This is the model class for table "page".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $slug
 * @property string $title
 * @property string $menu_title
 * @property string $text
 * @property string $category_template
 * @property string $pages_template
 * @property string $order
 * @property string $meta_title
 * @property string $meta_description
 * @property int $pagesCount
 * @property Page[] $pages
 * @property string $processedText
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
            [['title', 'category_template', 'pages_template'], 'required'],
            [['text'], 'string'],
            [['slug', 'title', 'menu_title', 'category_template', 'pages_template', 'meta_title', 'meta_description'], 'string', 'max' => 255],
	        [['slug'], 'unique', 'targetAttribute' => ['parent_id', 'slug']],
            [['order', 'parent_id'], 'integer'],
            [['order', 'parent_id'], 'default', 'value' => 0],
	        [['parent_id'], 'validateParent'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => Yii::t('custompages/category', 'Parent Category'),
            'slug' => Yii::t('custompages/category', 'Slug'),
            'title' => Yii::t('custompages/category', 'Title'),
            'menu_title' => Yii::t('custompages/category', 'Menu Title'),
            'text' => Yii::t('custompages/category', 'Text'),
            'category_template' => Yii::t('custompages/category', 'Category template'),
            'pages_template' => Yii::t('custompages/category', 'Page template'),
            'order' => Yii::t('custompages/category', 'Order'),
            'meta_title' => Yii::t('custompages/category', 'Meta Title'),
            'meta_description' => Yii::t('custompages/category', 'Meta Description'),
            'pagesCount' => Yii::t('custompages/category', 'Pages'),
        ];
    }

	/**
	 * Link with parent categories
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getParent()
	{
		return $this->hasOne(Category::class, ['id' => 'parent_id']);
	}

	/**
	 * Link with direct child categories
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getChildren()
	{
		return $this->hasMany(Category::class, ['parent_id' => 'id'])->orderBy(['order' => SORT_ASC]);
	}

    public function getPages()
    {
    	return $this->hasMany(Page::class, ['category_id' => 'id'])->orderBy(['published_at' => SORT_DESC, 'id' => SORT_DESC]);
    }

    public function getPagesCount()
    {
    	return $this->getPages()->count();
    }

    public static function getCategoriesList()
    {
    	return static::find()->select(['title', 'id'])->orderBy(['order' => SORT_ASC, 'id' => SORT_ASC])->indexBy('id')->column();
    }

	public function getProcessedText()
	{
		$categoryTextProcessor = Module::getInstance()->categoryTextProcessor;
		if (!empty($categoryTextProcessor) && is_callable($categoryTextProcessor)) {
			return call_user_func($categoryTextProcessor, $this->text);
		}
		return $this->text;
	}

	public function beforeSave($insert)
	{
		if (!$this->slug) {
			$this->slug = Inflector::slug($this->title);
		}
		return parent::beforeSave($insert);
	}

	/**
	 * Validates parent category.
	 *
	 * @param string $attribute the attribute currently being validated
	 * @param array $params the additional name-value pairs given in the rule
	 */
	public function validateParent($attribute, $params)
	{
		if (!$this->hasErrors()) {
			if ($this->id && $this->{$attribute} === $this->id) {
				$this->addError($attribute, Yii::t('custompages/category', 'Category can not be nested inside itself'));
			}
		}
	}
}
