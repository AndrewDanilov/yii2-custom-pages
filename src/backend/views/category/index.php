<?php

use yii\helpers\Html;
use andrewdanilov\custompages\backend\assets\CustomPagesAsset;

/* @var $this yii\web\View */
/* @var $tree array */

$this->title = Yii::t('custompages/category', 'Categories');
$this->params['breadcrumbs'][] = $this->title;

CustomPagesAsset::register($this);
?>
<div class="page-index">

	<p>
		<?= Html::a(Yii::t('custompages/category', 'Add page'), ['page/create'], ['class' => 'btn btn-success']) ?>
		<?= Html::a(Yii::t('custompages/category', 'Add category'), ['category/create'], ['class' => 'btn btn-primary']) ?>
	</p>

	<div class="custompages-tree-list">
		<?php foreach ($tree as $item) { ?>
			<div class="custompages-list-item level-<?= $item['level'] ?>">
				<div class="custompages-tree-actions">
					<?= Html::a('<span class="fa fa-pen"></span>', ['category/update', 'id' => $item['category']->id]) ?>
					<?= Html::a('<span class="fa fa-trash"></span>', ['category/delete', 'id' => $item['category']->id], ['data' => ['confirm' => 'Вы уверены, что хотите удалить этот элемент?', 'method' => 'post']]) ?>
				</div>
				<div class="custompages-tree-link"><?= Html::a($item['category']->title . ' (' . $item['category']->getPages()->count() . ')', ['page/index', 'PageSearch' => ['category_id' => $item['category']->id]]) ?></div>
			</div>
		<?php } ?>
	</div>
</div>
