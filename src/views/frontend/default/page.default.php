<?php

/* @var $this \yii\web\View */
/* @var $page \andrewdanilov\common\models\Page */

$this->title = $page->meta_title ?: $page->title;
$this->registerMetaTag([
	'name' => 'description',
	'content' => $page->meta_description,
]);
?>

<div class="section">
	<div class="container">
		<h1><?= $page->title ?></h1>

		<div class="page-text">

			<?= $page->text ?>

		</div>
	</div>
</div>
