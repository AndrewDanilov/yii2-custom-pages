<?php
namespace andrewdanilov\custompages\controllers\frontend;

use yii\db\Expression;
use yii\web\Controller;
use andrewdanilov\custompages\models\Category;
use andrewdanilov\custompages\models\Page;
use andrewdanilov\custompages\Module as CustomPages;
use andrewdanilov\custompages\helpers\TextHelper;

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
				preg_match_all('/(<p>)?\[gallery\s+([\w\d]+)(?:\s+(.+))?\](<\/p>)?/ui', $page->text, $matches, PREG_SET_ORDER);
				foreach ($matches as $index => $match) {
					$shortcode = $match[0];
					$album_id = $match[1];
					$params = TextHelper::parseGalleryParams($match[2]);
					$page->text = str_replace($shortcode, $this->renderPartial(CustomPages::getInstance()->getTemplatesPath() . '/_blocks/gallery', ['album' => $page->albums[$album_id], 'params' => $params]), $page->text);
				}
			}
			// placing sliders instead of slider-shortcodes
			if (strpos($page->text, '[slider') !== false) {
				preg_match_all('/(<p>)?\[slider\s+([\w\d]+)(?:\s+(.+))?\](<\/p>)?/ui', $page->text, $matches, PREG_SET_ORDER);
				foreach ($matches as $index => $match) {
					$shortcode = $match[0];
					$album_id = $match[1];
					$params = TextHelper::parseGalleryParams($match[2]);
					$page->text = str_replace($shortcode, $this->renderPartial(CustomPages::getInstance()->getTemplatesPath() . '/_blocks/slider', ['album' => $page->albums[$album_id], 'params' => $params]), $page->text);
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