<?php
namespace andrewdanilov\custompages\backend\models;

use andrewdanilov\custompages\common\models\Category;
use andrewdanilov\helpers\NestedCategoryHelper;
use yii\data\ActiveDataProvider;
use andrewdanilov\custompages\common\models\Page;

/**
 * PageSearch represents the model behind the search form of `andrewdanilov\custompages\common\models\Page`.
 */
class PageSearch extends Page
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id'], 'integer'],
            [['slug', 'title', 'published_at'], 'string'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Page::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
        ]);

        if ($this->category_id) {
        	// search in category and subcategories
        	$childrenIds = NestedCategoryHelper::getChildrenIds(Category::find(), $this->category_id);
	        $childrenIds[] = $this->category_id;
        	$query->andWhere(['category_id' => $childrenIds]);
        }

        if ($this->published_at !== null) {
            $published_at_search = implode('-', array_reverse(explode('.', $this->published_at)));
        } else {
            $published_at_search = null;
        }

	    $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'published_at', $published_at_search]);

        return $dataProvider;
    }
}
