<?php

use yii\helpers\Html;
use yii\grid\GridView;
use andrewdanilov\custompages\models\Category;
use andrewdanilov\custompages\Module as CustomPages;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel andrewdanilov\custompages\models\backend\CategorySearch */

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;

$category_templates = CustomPages::getInstance()->getCategoryTemplates();
$pages_templates = CustomPages::getInstance()->getPagesTemplates();
?>
<div class="page-index">

    <p>
        <?= Html::a('Добавить категорию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
	        [
		        'attribute' => 'id',
		        'headerOptions' => ['width' => 100],
	        ],
            'title',
            'slug',
            [
            	'attribute' => 'category_template',
	            'value' => function (Category $model) use ($category_templates) {
    	            if (isset($category_templates[$model->category_template])) {
		                return $category_templates[$model->category_template];
	                }
    	            return Html::tag('i', 'Нет');
	            }
            ],
	        [
            	'attribute' => 'pages_template',
	            'value' => function (Category $model) use ($pages_templates) {
    	            if (isset($pages_templates[$model->pages_template])) {
		                return $pages_templates[$model->pages_template];
	                }
    	            return Html::tag('i', 'Нет');
	            }
            ],
	        [
	        	'attribute' => 'pagesCount',
		        'format' => 'raw',
		        'value' => function (Category $model) {
			        return Html::a($model->pagesCount, ['page/index', 'PageSearch' => ['category_id' => $model->id]]);
		        },
			],

	        [
		        'class' => 'andrewdanilov\gridtools\FontawesomeActionColumn',
		        'template' => '{update}{delete}',
	        ],
        ],
    ]); ?>
</div>
