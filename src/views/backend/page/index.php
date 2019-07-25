<?php

use andrewdanilov\custompages\models\Category;
use andrewdanilov\custompages\models\Page;
use yii\helpers\Html;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel andrewdanilov\custompages\models\PageSearch */

$this->title = 'Страницы';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="page-index">

    <p>
        <?= Html::a('Добавить страницу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
	        [
		        'attribute' => 'id',
		        'headerOptions' => ['width' => 100],
	        ],
	        [
		        'attribute' => 'image',
		        'format' => 'raw',
		        'headerOptions' => ['style' => 'width:100px'],
		        'value' => function(Page $model) {
			        return Html::img($model->image, ['width' => '100']);
		        }
	        ],
            'title',
            'slug',
	        [
	        	'attribute' => 'category_id',
		        'format' => 'raw',
		        'value' => function (Page $model) {
    	            return Html::a($model->category->title, ['category/update', 'id' => $model->category_id]);
		        },
		        'filter' => Category::getCategoriesList(),
	        ],
	        [
		        'attribute' => 'published_at',
		        'format' => 'raw',
		        'filter' => DatePicker::widget([
			        'model' => $searchModel,
			        'attribute' => 'published_at',
			        'language' => 'ru',
			        'template' => '{input}{addon}',
			        'clientOptions' => [
				        'autoclose' => true,
				        'format' => 'dd.mm.yyyy',
				        'clearBtn' => true,
				        'todayBtn' => 'linked',
			        ],
			        'clientEvents' => [
				        'clearDate' => 'function (e) {$(e.target).find("input").change();}',
			        ],
		        ]),
	        ],

	        [
		        'class' => 'andrewdanilov\gridtools\FontawesomeActionColumn',
		        'template' => '{update}{delete}',
	        ],
        ],
    ]); ?>
</div>
