<?php

/* @var $this \yii\web\View */
/* @var $page \andrewdanilov\custompages\common\models\Page */
/* @var $tags \andrewdanilov\custompages\common\models\PageTag[] */

use andrewdanilov\custompages\frontend\assets\CustomPagesAsset;
use yii\helpers\Url;

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

		<div class="all-tags">
			<?php foreach ($tags as $tag) { ?>
				<a href="<?= Url::to(['/custompages/default/page-tag', 'slug' => $tag->slug]) ?>" class="blog__tag"><?= $tag->name ?></a>
			<?php } ?>
		</div>

		<div class="page-tags">
			<?php foreach ($page->tags as $tag) { ?>
				<a href="<?= Url::to(['/custompages/default/page-tag', 'slug' => $tag->slug]) ?>" class="blog__tag"><?= $tag->name ?></a>
			<?php } ?>
		</div>

		<div class="page-image">
			<img src="<?= $page->image ?>" alt=""/>
		</div>

		<div class="page-text">
			<?= $page->processedText ?>
		</div>

		<div class="page-source">
			Источник: <?= $page->getField('source') ?>
		</div>
	</div>
</div>
