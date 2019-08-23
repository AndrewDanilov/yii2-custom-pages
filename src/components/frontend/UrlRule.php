<?php
namespace andrewdanilov\custompages\components\frontend;

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
			$category = Category::findOne(['slug' => $category_slug, 'is_main' => 0]);
			if ($category) {
				if (isset($matches[2])) {
					$page_slug = $matches[2];
					$page = Page::findOne(['slug' => $page_slug, 'category_id' => $category->id, 'is_main' => 0]);
					if ($page) {
						return ['custompages/default/page', ['id' => $page->id]];
					}
				} else {
					return ['custompages/default/category', ['id' => $category->id]];
				}
			} else {
				if (!isset($matches[2])) {
					$page_slug = $matches[1];
					$page = Page::findOne(['slug' => $page_slug, 'hide_category_slug' => 1, 'is_main' => 0]);
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
