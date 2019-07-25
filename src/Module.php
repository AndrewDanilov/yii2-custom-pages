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

	public function getTemplatesPath()
	{
		if (empty($this->templatesPath)) {
			return '@andrewdanilov/custompages/views/frontend/default';
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
}