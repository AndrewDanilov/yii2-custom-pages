<?php

use yii\grid\GridViewAsset;
use yii\helpers\Html;
use andrewdanilov\custompages\assets\CustomPagesBackendAsset;

/* @var $this yii\web\View */
/* @var $tree array */

$this->title = Yii::t('custompages/backend/category', 'Categories');
$this->params['breadcrumbs'][] = $this->title;

$asset = CustomPagesBackendAsset::register($this);
$asset = GridViewAsset::register($this);
?>
<div class="page-index">

	<p>
		<?= Html::a(Yii::t('custompages/backend/category', 'Add page'), ['page/create'], ['class' => 'btn btn-success']) ?>
		<?= Html::a(Yii::t('custompages/backend/category', 'Add category'), ['category/create'], ['class' => 'btn btn-primary']) ?>
	</p>

	<div class="custompages-tree-list">
		<?php foreach ($tree as $item) { ?>
			<div class="custompages-list-item level-<?= $item['level'] ?>">
				<div class="custompages-tree-actions">
					<?= Html::a('<span class="fa fa-pen"></span>', ['update', 'id' => $item['category']->id]) ?>
					<?= Html::a('<span class="fa fa-trash"></span>', ['delete', 'id' => $item['category']->id], ['data' => ['confirm' => 'Вы уверены, что хотите удалить этот элемент?', 'method' => 'post']]) ?>
				</div>
				<div class="custompages-tree-link"><?= Html::a($item['category']->title . ' (' . $item['category']->getPages()->count() . ')', ['/custompages/page', 'PageSearch' => ['category_id' => $item['category']->id]]) ?></div>
			</div>
		<?php } ?>
	</div>
</div>
