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
		if ($page->text) {
			// placing galleries instead of gallery-shortcodes
			if (strpos($page->text, '[gallery') !== false) {
				foreach ($page->albums as $album_id => $album) {
					$page->text = preg_replace('/(<p>)?\[' . $album_id . '\](<\/p>)?/ui', $this->renderPartial(CustomPages::getInstance()->getTemplatesPath() . '/_blocks/gallery', ['album' => $album]), $page->text);
				}
			}
			// placing sliders instead of sliser-shortcodes
			if (strpos($page->text, '[slider') !== false) {
				foreach ($page->albums as $album_id => $album) {
					$page->text = preg_replace('/(<p>)?\[' . $album_id . '\](<\/p>)?/ui', $this->renderPartial(CustomPages::getInstance()->getTemplatesPath() . '/_blocks/slider', ['album' => $album]), $page->text);
				}
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