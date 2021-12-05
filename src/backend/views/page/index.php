<?php

use andrewdanilov\helpers\NestedCategoryHelper;
use andrewdanilov\custompages\backend\assets\CustomPagesAsset;
use andrewdanilov\custompages\backend\Module;
use andrewdanilov\custompages\backend\widgets\CategoryTree\CategoryTreeFilterList;
use andrewdanilov\custompages\common\models\Category;
use andrewdanilov\custompages\common\models\Page;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel andrewdanilov\custompages\backend\models\PageSearch */
/* @var $tree array */

$this->title = Yii::t('custompages/page', 'Pages');
$this->params['breadcrumbs'][] = $this->title;

$asset = CustomPagesAsset::register($this);

$columns1 = [
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
];

if (Module::getInstance()->enableCategories) {
	$category_filter = NestedCategoryHelper::getDropdownTree(Category::find(), 0, 'title');
	array_unshift($category_filter, Yii::t('custompages/page', 'Without Category'));
	$columns1[] = [
		'attribute' => 'category_id',
		'format' => 'raw',
		'value' => function (Page $model) {
			$path = NestedCategoryHelper::getCategoryPathDelimitedStr(Category::find(), $model->category_id, ' > ', 'title');
			return Html::a($path, ['category/update', 'id' => $model->category_id]);
		},
		'filter' => $category_filter,
	];
}

$columns2 = [
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
];
?>
<div class="page-index">

	<div class="custompages-editor-actions">
		<?php if (!Module::getInstance()->enableCategories) { ?>
			<?= Html::a(Yii::t('custompages/page', 'Add page'), ['page/create'], ['class' => 'btn btn-success']) ?>
		<?php } elseif ($searchModel->category_id) { ?>
			<?= Html::a(Yii::t('custompages/page', 'Add page'), ['page/create', 'category_id' => $searchModel->category_id], ['class' => 'btn btn-success']) ?>
			<?= Html::a(Yii::t('custompages/page', 'Add category'), ['category/create', 'parent_id' => $searchModel->category_id], ['class' => 'btn btn-primary']) ?>
		<?php } else { ?>
			<?= Html::a(Yii::t('custompages/page', 'Add page'), ['page/create'], ['class' => 'btn btn-success']) ?>
			<?= Html::a(Yii::t('custompages/page', 'Add category'), ['category/create'], ['class' => 'btn btn-primary']) ?>
		<?php } ?>
	</div>

	<div class="custompages-editor-boxes">
		<div class="shop-editor-box">
			<?= CategoryTreeFilterList::widget([
				'tree' => $tree,
				'filteredItemsListUriAction' => 'property/index',
				'filteredItemsListUriParamName' => 'PropertySearch',
			]) ?>
		</div>
	</div>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => array_merge($columns1, $columns2),
	]); ?>
</div>
