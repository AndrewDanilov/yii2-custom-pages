<?php
namespace andrewdanilov\custompages\behaviors;

use Yii;
use yii\db\ActiveRecord;

/**
 * DateBehavior class
 */
class DateBehavior extends \yii\base\Behavior
{
	/**
	 * 'dateAttributes' => [
	 *  	'created_at' => \andrewdanilov\custompages\behaviors\DateBehavior::DATETIME_FORMAT,
	 *  	'updated_at' => \andrewdanilov\custompages\behaviors\DateBehavior::DATE_FORMAT,
	 *  	'showed_at', // equal to: 'showed_at' => \andrewdanilov\custompages\behaviors\DateBehavior::DATE_FORMAT
	 *	],
	 */
	public $dateAttributes = [];

	const DATE_FORMAT = 1;
	const DATETIME_FORMAT = 2;

	/**
	 * Events list
	 * @return array
	 */
	public function events()
	{
		return [
			ActiveRecord::EVENT_AFTER_FIND => 'onAfterFind',
			ActiveRecord::EVENT_BEFORE_INSERT => 'onBeforeSave',
			ActiveRecord::EVENT_BEFORE_UPDATE => 'onBeforeSave',
		];
	}

	//////////////////////////////////////////////////////////////////

	/**
	 * После выборки данных из базы преобразует все даты к формату для отображения
	 */
	public function onAfterFind()
	{
		if (is_array($this->dateAttributes)) {
			foreach ($this->dateAttributes as $key => $attribute) {
				if (is_string($key)) {
					$format = $attribute;
					$attribute = $key;
				} else {
					$format = self::DATE_FORMAT;
				}
				$this->owner->{$attribute} = $this->getDisplayDate($attribute, $format == self::DATETIME_FORMAT);
			}
		}
	}

	/**
	 * Перед сохранением данных в базу преобразует все даты к формату БД
	 */
	public function onBeforeSave()
	{
		if (is_array($this->dateAttributes)) {
			foreach ($this->dateAttributes as $key => $attribute) {
				if (is_string($key)) {
					$format = $attribute;
					$attribute = $key;
				} else {
					$format = self::DATE_FORMAT;
				}
				$this->owner->{$attribute} = $this->getISODate($attribute, $format == self::DATETIME_FORMAT);
			}
		}
	}

	//////////////////////////////////////////////////////////////////

	/**
	 * Возвращает дату в формате БД
	 *
	 * @param $attribute
	 * @param bool $use_time
	 * @return false|null|string
	 */
	public function getISODate($attribute, $use_time=false)
	{
		$date_format = 'Y-m-d';
		if ($use_time) {
			$date_format .= ' H:i:s';
		}
		return $this->owner->{$attribute} ? date($date_format, strtotime($this->owner->{$attribute})) : null;
	}

	/**
	 * Возвращает дату в формате для отображения
	 *
	 * @param $attribute
	 * @param bool $use_time
	 * @return false|null|string
	 */
	public function getDisplayDate($attribute, $use_time=false)
	{
		if ($use_time) {
			return $this->owner->{$attribute} ? Yii::$app->formatter->asDateTime($this->owner->{$attribute}) : null;
		}
		return $this->owner->{$attribute} ? Yii::$app->formatter->asDate($this->owner->{$attribute}) : null;
	}
}