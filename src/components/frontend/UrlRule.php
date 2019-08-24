<?php
namespace andrewdanilov\custompages\components\frontend;

use yii\db\Expression;
use yii\web\UrlRuleInterface;
use yii\base\BaseObject;
use andrewdanilov\custompages\models\Page;
use andrewdanilov\custompages\models\Category;

class UrlRule extends BaseObject implements UrlRuleInterface
{
	public function createUrl($manager, $route, $params)
	{
		if ($route === 'custompages/default/category') {
			if ($params['id']) {
				$category = Category::findOne(['id' => $params['id']]);
				if ($category) {
					return $category->slug;
				}
			}
		}
		if ($route === 'custompages/default/page') {
			if ($params['id']) {
				$page = Page::findOne(['id' => $params['id']]);
				if ($page) {
					if ($page->hide_category_slug) {
						return $page->slug;
					}
					return $page->category->slug . '/' . $page->slug;
				}
			}
		}
		return false;
	}

	/**
	 * @param \yii\web\UrlManager $manager
	 * @param \yii\web\Request $request
	 * @return array|bool
	 * @throws \yii\base\InvalidConfigException
	 */
	public function parseRequest($manager, $request)
	{
		$pathInfo = $request->getPathInfo();
		if (preg_match('%^([\w_-]+)(?:\/([\w_-]+))?$%', $pathInfo, $matches)) {
			$category_slug = $matches[1];
			$category = Category::findOne(['slug' => $category_slug]);
			if ($category) {
				if (isset($matches[2])) {
					$page_slug = $matches[2];
					$page = Page::find()->where([
						'slug' => $page_slug,
						'is_main' => 0,
						'hide_category_slug' => 0,
						'category_id' => $category->id,
					])->andWhere(['>=', 'published_at', new Expression('curdate()')])->one();
					if ($page) {
						return ['custompages/default/page', ['id' => $page->id]];
					}
				} else {
					return ['custompages/default/category', ['id' => $category->id]];
				}
			} else {
				if (!isset($matches[2])) {
					$page_slug = $matches[1];
					$page = Page::find()->where([
						'slug' => $page_slug,
						'is_main' => 0,
						'hide_category_slug' => 1,
					])->andWhere(['>=', 'published_at', new Expression('curdate()')])->one();
					if ($page) {
						return ['custompages/default/page', ['id' => $page->id]];
					}
				}
			}
		}
		if ($pathInfo === '') {
			$page = Page::findOne(['is_main' => 1]);
			if ($page) {
				return ['custompages/default/page', ['id' => $page->id]];
			}
		}
		return false;
	}
}
