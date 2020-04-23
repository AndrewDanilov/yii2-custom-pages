<?php
namespace andrewdanilov\custompages\components\frontend;

use yii\db\Expression;
use yii\web\UrlRuleInterface;
use yii\base\BaseObject;
use andrewdanilov\custompages\models\Page;
use andrewdanilov\custompages\models\Category;
use andrewdanilov\helpers\NestedCategoryHelper;

class UrlRule extends BaseObject implements UrlRuleInterface
{
	public function createUrl($manager, $route, $params)
	{
		if ($route === 'custompages/default/category') {
			if ($params['id']) {
				$path = NestedCategoryHelper::getCategoryPath(Category::find()->all(), $params['id'], 'slug');
				if (!empty($path)) {
					return $path;
				}
			}
		}
		if ($route === 'custompages/default/page') {
			if ($params['id']) {
				$page = Page::findOne(['id' => $params['id']]);
				if ($page) {
					if ($page->is_main) {
						return '/';
					}
					if ($page->category_id === 0) {
						return $page->slug;
					}
					$path = NestedCategoryHelper::getCategoryPath(Category::find()->all(), $page->category->id, 'slug');
					if (!empty($path)) {
						return $path . '/' . $page->slug;
					}
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
		if (preg_match('%^[\w\-]+(?:/[\w\-]+)*$%', $pathInfo, $matches)) {
			$path = explode('/', $pathInfo);
			$parent_id = 0;
			// we need to go though all categories chain
			foreach ($path as $index => $path_item) {
				$category = Category::findOne([
					'slug' => $path_item,
					'parent_id' => $parent_id,
				]);
				if ($category) {
					// category exists, store it and go to next path_item
					$parent_id = $category->id;
				} else {
					// it's not category, maybe it's a page.
					// only last path_item can be a page slug
					if ($index === count($path) - 1) {
						$page = Page::find()->where([
							'slug' => $path_item,
							'is_main' => 0,
							'category_id' => $parent_id,
						])->andWhere([
							'<=', 'published_at', new Expression('curdate()'),
						])->one();
						if ($page) {
							return ['custompages/default/page', ['id' => $page->id]];
						}
					}
					return false;
				}
			}
			return ['custompages/default/category', ['id' => $parent_id]];
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
