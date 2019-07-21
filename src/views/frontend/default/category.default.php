<?php

/* @var $this \yii\web\View */
/* @var $category \andrewdanilov\custompages\models\Category */
/* @var $pages \andrewdanilov\custompages\models\Page[] */

$this->title = $category->meta_title ?: $category->title;
$this->registerMetaTag([
	'name' => 'description',
	'content' => $category->meta_description,
]);
?>

<div class="section">
	<div class="container">
		<h1><?= $category->title ?></h1>

		<div class="category-text">

			<?= $category->text ?>

		</div>

		<div class="category-list">

			<?php foreach ($pages as $page) { ?>

				<div class="category-list-item">

					<div class="list-item-image">
						<img src="<?= $page->image ?>" alt="">
					</div>
					<div class="list-item-content">
						<h4><?= $page->title ?></h4>
						<div>
							<?= $page->text ?>
						</div>
					</div>

				</div>

			<?php } ?>

		</div>
	</div>
</div>
