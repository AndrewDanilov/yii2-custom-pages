<?php
namespace andrewdanilov\custompages\frontend\components;

use yii\db\Expression;
use yii\web\UrlRuleInterface;
use yii\base\BaseObject;
use andrewdanilov\custompages\common\models\Category;
use andrewdanilov\custompages\common\models\Page;
use andrewdanilov\custompages\common\models\PageTag;
use andrewdanilov\helpers\NestedCategoryHelper;

class UrlRule extends BaseObject implements UrlRuleInterface
{
	public function createUrl($manager, $route, $params)
	{
		if ($route === 'custompages/default/page-tag') {
            // url with tag can contain category path
            if (!empty($params['category_id'])) {
                $path = NestedCategoryHelper::getCategoryPathDelimitedStr(Category::find(), $params['category_id'], '/', 'slug');
                unset($params['category_id']);
            } else {
                $path = '';
            }
            if (!empty($params['id'])) {
                $tag = PageTag::findOne(['id' => $params['id']]);
                unset($params['id']);
            } elseif (!empty($params['slug'])) {
				$tag = PageTag::findOne(['slug' => $params['slug']]);
                unset($params['slug']);
			} else {
                // tag was not set
                $tag = null;
            }
            if ($tag) {
                $path .= '/' . $tag->slug;
                if (!empty($params) && ($query = http_build_query($params)) !== '') {
                    $path .= '?' . $query;
                }
                return $path;
            }
		} elseif ($route === 'custompages/default/page') {
			if (!empty($params['id'])) {
				$page = Page::findOne(['id' => $params['id']]);
				if ($page) {
					if ($page->is_main) {
						return '/';
					}
					if ($page->category_id === 0) {
						return $page->slug;
					}
					$path = NestedCategoryHelper::getCategoryPathDelimitedStr(Category::find(), $page->category_id, '/', 'slug');
					if (!empty($path)) {
						return $path . '/' . $page->slug;
					}
				}
			}
		} elseif ($route === 'custompages/default/category') {
			if (!empty($params['id'])) {
				$path = NestedCategoryHelper::getCategoryPathDelimitedStr(Category::find(), $params['id'], '/', 'slug');
				if (!empty($path)) {
                    unset($params['id']);
                    if (!empty($params) && ($query = http_build_query($params)) !== '') {
                        $path .= '?' . $query;
                    }
                    return $path;
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
			// We need to go through all nested categories chain
			foreach ($path as $index => $path_item) {
				$category = Category::findOne([
					'slug' => $path_item,
					'parent_id' => $parent_id,
				]);
				if ($category) {
					// Category exists, store it and go to next path_item
					$parent_id = $category->id;
				} else {
					// It's not category, maybe it's a tag or a page.
					// Only last path_item can be a tag slug or a page slug
					if ($index === count($path) - 1) {
                        // Check if it is a tag
                        $tag = PageTag::findOne([
                            'slug' => $path_item,
                        ]);
                        if ($tag) {
                            return ['custompages/default/page-tag', ['id' => $tag->id, 'category_id' => $parent_id]];
                        }
                        // Check if it is a page
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
