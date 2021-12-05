<?php

/* @var View $this */
/* @var array $tree */
/* @var string $filteredItemsListUriAction */
/* @var string $filteredItemsListUriParamName */

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;

$filterValues = array_filter(Yii::$app->request->get($filteredItemsListUriParamName, []));
?>

<?php if (!empty($tree)) { ?>
	<div class="custompages-tree-list">
		<?php foreach ($tree as $item) { ?>
			<div class="custompages-list-item level-<?= $item['level'] ?> <?php if (ArrayHelper::getValue($filterValues, 'category_id') == $item['category']['id']) { ?>active-item<?php } ?>">
				<div class="custompages-tree-actions">
					<?= Html::a('<span class="fa fa-folder"></span>', [$filteredItemsListUriAction, $filteredItemsListUriParamName => ['category_id' => $item['category']['id']]], ['title' => Yii::t('custompages/category', 'Open')]); ?>
					<?= Html::a('<span class="fa fa-pen"></span>', ['category/update', 'id' => $item['category']['id']], ['title' => Yii::t('custompages/category', 'Edit')]) ?>
					<?= Html::a('<span class="fa fa-trash"></span>', ['category/delete', 'id' => $item['category']['id']], ['data' => ['confirm' => Yii::t('custompages/category', 'Are you sure you want to delete this category?'), 'method' => 'post'], 'title' => Yii::t('custompages/category', 'Remove')]) ?>
				</div>
				<div class="custompages-tree-link"><?= Html::a($item['category']['title'] . ' (' . $item['category']['count'] . ')', [$filteredItemsListUriAction, $filteredItemsListUriParamName => ['category_id' => $item['category']['id']]], ['title' => Yii::t('custompages/category', 'Open')]) ?></div>
			</div>
		<?php } ?>
	</div>
<?php } else { ?>
	<div class="alert alert-warning">
		<?= Yii::t('custompages/category', 'There is no categories yet. Please, add some categories by clicking button <b>New category</b>') ?>
	</div>
<?php } ?>