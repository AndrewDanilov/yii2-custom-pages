<?php
namespace andrewdanilov\custompages;

use Yii;
use yii\helpers\FileHelper;
use andrewdanilov\custompages\common\exceptions\CategoryDefaultTemplatePathNotFoundException;
use andrewdanilov\custompages\common\exceptions\PageDefaultTemplatePathNotFoundException;
use andrewdanilov\custompages\common\exceptions\TemplatesPathNotFoundException;

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
		// path to categories and pages templates
		if (empty($this->templatesPath)) {
			$this->templatesPath = '@andrewdanilov/custompages/frontend/views';
		}
		// path to translates
		if (empty($this->translatesPath)) {
			$this->translatesPath = '@andrewdanilov/custompages/common/messages';
		}
		// I18N
		$this->registerTranslations();
		parent::init();
	}

	public function getCategoryTemplates()
	{
		$path = Yii::getAlias($this->templatesPath);
		if (!is_dir($path)) {
			throw new TemplatesPathNotFoundException($path);
		}
		if (!file_exists($path . '/category.default.php')) {
			throw new CategoryDefaultTemplatePathNotFoundException($path . '/category.default.php');
		}
		$files = FileHelper::findFiles($path, [
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
		$path = Yii::getAlias($this->templatesPath);
		if (!is_dir($path)) {
			throw new TemplatesPathNotFoundException($path);
		}
		if (!file_exists($path . '/category.default.php')) {
			throw new PageDefaultTemplatePathNotFoundException($path . '/page.default.php');
		}
		$files = FileHelper::findFiles($path, [
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
				'custompages/category' => 'category.php',
				'custompages/page' => 'page.php',
				'custompages/page-tag' => 'page-tag.php',
				'custompages/common' => 'common.php',
			],
		];
	}
}