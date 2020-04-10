<?php

use andrewdanilov\custompages\assets\CustomPagesAsset;

/* @var $this \yii\web\View */
/* @var $page \andrewdanilov\custompages\models\Page */

$this->title = $page->meta_title ?: $page->title;
$this->registerMetaTag([
	'name' => 'description',
	'content' => $page->meta_description,
]);

CustomPagesAsset::register($this);
?>

<div class="section">
	<div class="container">
		<h1><?= $page->title ?></h1>

		<div class="page-image">
			<img src="<?= $page->image ?>" alt=""/>
		</div>

		<div class="page-text">
			<?= $page->text ?>
		</div>
	</div>
</div>
