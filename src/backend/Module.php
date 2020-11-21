<?php
namespace andrewdanilov\custompages\backend;

/**
 * Class Module
 *
 * @package andrewdanilov\custompages\backend
 * @property string|array $access
 * @property bool $enableTags
 * @property bool $enableAlbums
 * @property bool $enableCategories
 * @property array $fileManager
 */
class Module extends \andrewdanilov\custompages\Module
{
	public $access = ['@'];
	public $enableTags = true;
	public $enableAlbums = true;
	public $enableCategories = true;
	public $fileManager;

	public function init()
	{
		// controller namespace if not defined directly
		if (empty($this->controllerNamespace) && empty($this->controllerMap)) {
			$this->controllerNamespace = 'andrewdanilov\custompages\backend\controllers';
		}
		// file manager
		if (empty($this->fileManager)) {
			$this->fileManager = [
				'basePath' => '@frontend/web',
				'paths' => [
					[
						'name' => 'News',
						'path' => 'upload/images/news',
					],
					[
						'name' => 'Articles',
						'path' => 'upload/images/articles',
					],
				],
			];
		}
		$elfinderRoots = [];
		foreach ($this->fileManager['paths'] as $path) {
			$elfinderRoots[] = [
				'baseUrl' => '',
				'basePath' => $this->fileManager['basePath'],
				'path' => $path['path'],
				'name' => $path['name'],
			];
		}
		$this->controllerMap['elfinder'] = [
			'class' => 'mihaildev\elfinder\Controller',
			'access' => $this->access,
			'roots' => $elfinderRoots,
		];
		parent::init();
	}
}