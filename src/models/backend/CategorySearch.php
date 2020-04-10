<?php
namespace andrewdanilov\custompages\models\backend;

use yii\data\ActiveDataProvider;
use andrewdanilov\custompages\models\Category;

/**
 * CategorySearch represents the model behind the search form of `andrewdanilov\custompages\models\Category`.
 */
class CategorySearch extends Category
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'order'], 'integer'],
            [['slug', 'title', 'category_template', 'pages_template'], 'string'],
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
        $query = Category::find();

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
            'order' => $this->order,
        ]);

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'category_template', $this->category_template])
            ->andFilterWhere(['like', 'pages_template', $this->pages_template]);

        return $dataProvider;
    }
}
