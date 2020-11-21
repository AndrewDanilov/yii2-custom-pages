<?php

use yii\helpers\Html;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;
use andrewdanilov\helpers\NestedCategoryHelper;
use andrewdanilov\custompages\backend\Module;
use andrewdanilov\custompages\backend\assets\CustomPagesAsset;
use andrewdanilov\custompages\common\models\Category;
use andrewdanilov\custompages\common\models\Page;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel andrewdanilov\custompages\backend\models\PageSearch */

$this->title = Yii::t('custompages/page', 'Pages');
$this->params['breadcrumbs'][] = $this->title;

$asset = CustomPagesAsset::register($this);
?>
<div class="page-index">

    <p>
	    <?php if (!Module::getInstance()->enableCategories) { ?>
		    <?= Html::a(Yii::t('custompages/page', 'Add page'), ['page/create'], ['class' => 'btn btn-success']) ?>
	    <?php } elseif ($searchModel->category_id) { ?>
	        <?= Html::a(Yii::t('custompages/page', 'Add page'), ['page/create', 'category_id' => $searchModel->category_id], ['class' => 'btn btn-success']) ?>
		    <?= Html::a(Yii::t('custompages/page', 'Add category'), ['category/create', 'parent_id' => $searchModel->category_id], ['class' => 'btn btn-primary']) ?>
	    <?php } else { ?>
	        <?= Html::a(Yii::t('custompages/page', 'Add page'), ['page/create'], ['class' => 'btn btn-success']) ?>
		    <?= Html::a(Yii::t('custompages/page', 'Add category'), ['category/create'], ['class' => 'btn btn-primary']) ?>
	    <?php } ?>
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
    	            $path = NestedCategoryHelper::getCategoryPath(Category::find(), $model->category_id, 'title', 'parent_id', ' > ');
    	            return Html::a($path, ['category/update', 'id' => $model->category_id]);
		        },
		        'filter' => NestedCategoryHelper::getDropdownTree(Category::find(), 0, 'title'),
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
