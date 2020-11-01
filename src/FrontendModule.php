<?php
namespace andrewdanilov\custompages;

class FrontendModule extends BaseModule
{
	public $pageShortTextWordsCount = 50;
	public $pageTextProcessor;
	public $categoryTextProcessor;

	public function init()
	{
		// controller namespace if not defined directly
		if (empty($this->controllerNamespace) && empty($this->controllerMap)) {
			$this->controllerNamespace = 'andrewdanilov\custompages\controllers\frontend';
		}
		parent::init();
	}
}