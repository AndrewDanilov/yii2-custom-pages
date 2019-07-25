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
		$template = CustomPages::getInstance()->getTemplatesPath() . '/' . $page->category->pages_template;
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
		$template = CustomPages::getInstance()->getTemplatesPath() . '/' . $category->category_template;
		return $this->render($template, [
			'category' => $category,
			'pages' => $category->pages,
		]);
	}
}