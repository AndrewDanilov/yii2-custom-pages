<?php
namespace andrewdanilov\custompages\frontend;

class Module extends \andrewdanilov\custompages\Module
{
	public $pageShortTextWordsCount = 50;
	public $pageTextProcessor;
	public $categoryTextProcessor;
	public $paginationForcePageParam = false;
	public $paginationPageParam = 'page';
	public $paginationPageSizeParam = false;
	public $paginationPageSize = 20;

	public function init()
	{
		// controller namespace if not defined directly
		if (empty($this->controllerNamespace) && empty($this->controllerMap)) {
			$this->controllerNamespace = 'andrewdanilov\custompages\frontend\controllers';
		}
		parent::init();
	}
}