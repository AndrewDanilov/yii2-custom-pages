<?php
namespace andrewdanilov\custompages\controllers\frontend;

use yii\web\Controller;
use andrewdanilov\custompages\models\Category;
use andrewdanilov\custompages\models\Page;
use andrewdanilov\custompages\Module as CustomPages;

/**
 * Default controller
 */
class DefaultController extends Controller
{
	/**
	 * @param int $id
	 * @return mixed
	 */
	public function actionPage($id)
	{
		$page = Page::find()->where(['id' => $id])->one();
		$templates = CustomPages::getInstance()->getPagesTemplates();
		$template = $page->category->pages_template;
		if (!isset($templates[$template])) {
			$template = 'page.default';
		}
		return $this->render($template, [
			'page' => $page,
		]);
	}

	/**
	 * @param $id
	 * @return string
	 */
	public function actionCategory($id)
	{
		$category = Category::find()->where(['id' => $id])->one();
		$templates = CustomPages::getInstance()->getCategoryTemplates();
		$template = $category->category_template;
		if (!isset($templates[$template])) {
			$template = 'category.default';
		}
		return $this->render($template, [
			'category' => $category,
			'pages' => $category->pages,
		]);
	}
}