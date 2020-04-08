<?php

use Yii;
use yii\helpers\Html;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;
use andrewdanilov\custompages\assets\CustomPagesBackendAsset;
use andrewdanilov\custompages\models\Category;
use andrewdanilov\custompages\models\Page;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel andrewdanilov\custompages\models\backend\PageSearch */

$this->title = Yii::t('custompages/backend/page', 'Pages');
$this->params['breadcrumbs'][] = $this->title;

$asset = CustomPagesBackendAsset::register($this);
?>
<div class="page-index">

    <p>
	    <?= Html::a(Yii::t('custompages/backend/page', 'Add page'), ['page/create'], ['class' => 'btn btn-success']) ?>
	    <?= Html::a(Yii::t('custompages/backend/page', 'Add category'), ['category/create'], ['class' => 'btn btn-primary']) ?>
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
	        	'attribute' => 'is_main',
		        'format' => 'raw',
	        	'value' => function (Page $model) use ($asset) {
			        if ($model->is_main) {
			        	return Html::img($asset->baseUrl . '/images/star.svg', ['width' => 20]);
			        }
			        return '';
		        },
			],

	        [
		        'class' => 'andrewdanilov\gridtools\FontawesomeActionColumn',
		        'template' => '{update}{delete}',
	        ],
        ],
    ]); ?>
</div>
