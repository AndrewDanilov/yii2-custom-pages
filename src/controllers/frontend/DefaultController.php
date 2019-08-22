<?php
namespace andrewdanilov\custompages\controllers\frontend;

use yii\db\Expression;
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
		$page = Page::find()
			->andWhere(['id' => $id])
			->andWhere(['<=', 'published_at', new Expression('curdate()')])
			->one();
		if ($page->text && strpos($page->text, '[slider') !== false) {
			foreach ($page->sliders as $slider_id => $slider) {
				$page->text = preg_replace('/(<p>)?\[' . $slider_id . '\](<\/p>)?/ui', $this->renderPartial(CustomPages::getInstance()->getTemplatesPath() . '/_blocks/slider', ['slider' => $slider]), $page->text);
			}
		}
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