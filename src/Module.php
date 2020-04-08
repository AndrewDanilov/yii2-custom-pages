<?php
namespace andrewdanilov\custompages;

use Yii;
use yii\helpers\FileHelper;

/**
 * @property array $categoryTemplates
 * @property array $pagesTemplates
 */
class Module extends \yii\base\Module
{
	public $templatesPath;
	public $translatesPath;

	public function init()
	{
		// frontend by default
		if (empty($this->controllerNamespace) && empty($this->controllerMap)) {
			$this->controllerNamespace = 'andrewdanilov\custompages\controllers\frontend';
		}
		// path to translates
		if (empty($this->translatesPath)) {
			$this->translatesPath = '@andrewdanilov/custompages/messages';
		}
		// I18N
		$this->registerTranslations();
		parent::init();
	}

	public function getTemplatesPath()
	{
		if (empty($this->templatesPath)) {
			return '@andrewdanilov/custompages/views/frontend';
		}
		return $this->templatesPath;
	}

	public function getCategoryTemplates()
	{
		$files = FileHelper::findFiles(Yii::getAlias($this->getTemplatesPath()), [
			'except' => ['category.default.php'],
			'only' => ['category.*.php'],
			'recursive' => false,
		]);
		$templates = [
			'category.default.php' => 'category.default.php',
		];
		foreach ($files as $file) {
			$template = basename($file);
			$templates[$template] = $template;
		}
		return $templates;
	}

	public function getPagesTemplates()
	{
		$files = FileHelper::findFiles(Yii::getAlias($this->getTemplatesPath()), [
			'except' => ['page.default.php'],
			'only' => ['page.*.php'],
			'recursive' => false,
		]);
		$templates = [
			'page.default.php' => 'page.default.php',
		];
		foreach ($files as $file) {
			$template = basename($file);
			$templates[$template] = $template;
		}
		return $templates;
	}

	public function registerTranslations()
	{
		Yii::$app->i18n->translations['custompages/*'] = [
			'class'          => 'yii\i18n\PhpMessageSource',
			'sourceLanguage' => 'en-US',
			'basePath'       => $this->translatesPath,
			'fileMap'        => [
				'custompages/backend/category' => 'backend/category.php',
				'custompages/backend/page' => 'backend/page.php',
				'custompages/backend/tag' => 'backend/tag.php',
				'custompages/backend' => 'backend/other.php',
			],
		];
	}
}