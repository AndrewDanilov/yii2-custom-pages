<?php

/* @var $this \yii\web\View */
/* @var $pageTag \andrewdanilov\custompages\common\models\PageTag */
/* @var $pages \andrewdanilov\custompages\common\models\Page[] */

use andrewdanilov\custompages\frontend\assets\CustomPagesAsset;

$this->title = $pageTag->meta_title ?: $pageTag->name;
$this->registerMetaTag([
	'name' => 'description',
	'content' => $pageTag->meta_description,
]);

CustomPagesAsset::register($this);
?>

<div class="section">
	<div class="container">
		<h1><?= $pageTag->name ?></h1>

		<div class="tag-list">

			<?php foreach ($pages as $page) { ?>

				<div class="tag-list-item">

					<div class="list-item-image">
						<img src="<?= $page->image ?>" alt="">
					</div>
					<div class="list-item-content">
						<a class="list-item-title" href="<?= \yii\helpers\Url::to(['default/page', 'id' => $page->id]) ?>"><?= $page->title ?></a>
						<div>
							<?= $page->shortText ?>
						</div>
					</div>

				</div>

			<?php } ?>

		</div>
	</div>
</div>
