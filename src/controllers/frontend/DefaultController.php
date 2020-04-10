<?php
namespace andrewdanilov\custompages\controllers\frontend;

use yii\db\Expression;
use yii\web\Controller;
use andrewdanilov\custompages\models\Category;
use andrewdanilov\custompages\models\Page;
use andrewdanilov\custompages\Module as CustomPages;
use andrewdanilov\custompages\helpers\AlbumHelper;

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
			$albums = AlbumHelper::parseShortcodes('gallery', $page->text, $page->albums);
			foreach ($albums as $album) {
				$page->text = str_replace($album['shortcode'], $this->renderPartial(CustomPages::getInstance()->templatesPath . '/_blocks/gallery', ['album' => $album]), $page->text);
			}
			// placing sliders instead of slider-shortcodes
			$albums = AlbumHelper::parseShortcodes('slider', $page->text, $page->albums);
			foreach ($albums as $album) {
				$page->text = str_replace($album['shortcode'], $this->renderPartial(CustomPages::getInstance()->templatesPath . '/_blocks/slider', ['album' => $album]), $page->text);
			}
		}
		$template = CustomPages::getInstance()->templatesPath . '/' . $page->category->pages_template;
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
		$template = CustomPages::getInstance()->templatesPath . '/' . $category->category_template;
		return $this->render($template, [
			'category' => $category,
			'pages' => $category->pages,
		]);
	}
}