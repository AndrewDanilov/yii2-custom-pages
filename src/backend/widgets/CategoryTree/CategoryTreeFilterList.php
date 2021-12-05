<?php
namespace andrewdanilov\custompages\backend\widgets\CategoryTree;

use yii\base\Widget;

class CategoryTreeFilterList extends Widget
{
	// pseudo-hierarchical list of categories as plane array with depth levels
	public $tree;
	// controller/action id of page on which filter applies, i.e. 'product/index'
	public $filteredItemsListUriAction;
	// uri query param name which passes filter values to ActiveForm, i.e. 'ProductSearch'
	public $filteredItemsListUriParamName;

	public function run()
	{
		return $this->render('tree-list', [
			'tree' => $this->tree,
			'filteredItemsListUriAction' => $this->filteredItemsListUriAction,
			'filteredItemsListUriParamName' => $this->filteredItemsListUriParamName,
		]);
	}
}