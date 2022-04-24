<?php

/* @var $this \yii\web\View */
/* @var $category \andrewdanilov\custompages\common\models\Category */
/* @var $pages \andrewdanilov\custompages\common\models\Page[] */
/* @var $tags \andrewdanilov\custompages\common\models\PageTag[] */

use andrewdanilov\custompages\frontend\assets\CustomPagesAsset;
use yii\helpers\Url;

$this->title = $category->meta_title ?: $category->title;
$this->registerMetaTag([
	'name' => 'description',
	'content' => $category->meta_description,
]);

CustomPagesAsset::register($this);
?>

<div class="section">
	<div class="container">
		<h1><?= $category->title ?></h1>

		<div class="all-tags">
			<?php foreach ($tags as $tag) { ?>
				<a href="<?= Url::to(['/custompages/default/page-tag', 'slug' => $tag->slug]) ?>" class="blog__tag"><?= $tag->name ?></a>
			<?php } ?>
		</div>

		<div class="category-text">

			<?= $category->processedText ?>

		</div>

		<div class="category-list">

			<?php foreach ($pages as $page) { ?>

				<div class="category-list-item">

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
