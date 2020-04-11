<?php
namespace andrewdanilov\custompages\models;

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
 * @property boolean $hide_category_slug
 * @property string $image
 * @property string $title
 * @property string $text
 * @property string $albums
 * @property string $published_at
 * @property boolean $is_main
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
        	[['title', 'category_id'], 'required'],
            [['image', 'text', 'published_at'], 'string'],
            [['category_id'], 'integer'],
            [['slug', 'title', 'meta_title', 'meta_description'], 'string', 'max' => 255],
	        [['slug'], 'unique', 'targetAttribute' => ['category_id', 'slug']],
	        [['published_at'], 'default', 'value' => date('d.m.Y')],
	        [['albums'], 'safe'],
	        [['hide_category_slug', 'is_main'], 'boolean'],
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
            'hide_category_slug' => Yii::t('custompages/backend/page', 'Hide category slug from url'),
            'image' => Yii::t('custompages/backend/page', 'Cover'),
            'title' => Yii::t('custompages/backend/page', 'Title'),
            'text' => Yii::t('custompages/backend/page', 'Text'),
	        'albums' => Yii::t('custompages/backend/page', 'Albums'),
            'published_at' => Yii::t('custompages/backend/page', 'Published'),
            'is_main' => Yii::t('custompages/backend/page', 'Main'),
            'meta_title' => Yii::t('custompages/backend/page', 'Meta Title'),
            'meta_description' => Yii::t('custompages/backend/page', 'Meta Description'),
            'tagIds' => Yii::t('custompages/backend/page', 'Tags'),
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
		$pageShortTextWordsCount = CustomPages::getInstance()->pageShortTextWordsCount;
		$text = strip_tags($this->text, '<p><i><b><strong>');
		$text = str_replace('&nbsp;', ' ', $text);
		$text = preg_replace('~<p[^>]*>\s*</p>~', '', $text);
		$text = preg_replace('~<i[^>]*>\s*</i>~', '', $text);
		$text = preg_replace('~<b[^>]*>\s*</b>~', '', $text);
		$text = preg_replace('~<strong[^>]*>\s*</strong>~', '', $text);
		if (preg_match_all('~<p[^>]*>(.+)</p>~Us', $text, $matches)) {
			$paragraphs = $matches[1];
			$totalWordsCount = 0;
			$text = '';
			foreach ($paragraphs as $paragraph) {
				$wordsCount = preg_match_all('~[\p{L}\'\-\xC2\xAD]+~u', trim(strip_tags($paragraph)));
				$totalWordsCount += $wordsCount;
				if ($totalWordsCount < $pageShortTextWordsCount) {
					$text .= '<p>' . $paragraph . '</p>';
				} else {
					$diff = $totalWordsCount - $pageShortTextWordsCount;
					if ($diff > 0) {
						$text .= '<p>' . StringHelper::truncateWords($paragraph, $wordsCount - $diff, '...', true) . '</p>';
					}
					break;
				}
			}
			return $text;
		}
		return StringHelper::truncateWords(strip_tags($text), $pageShortTextWordsCount, '...', true);
	}
}
