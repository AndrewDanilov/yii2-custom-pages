<?php

/* @var $this \yii\web\View */
/* @var $pageTag \andrewdanilov\custompages\common\models\PageTag */
/* @var $pages \andrewdanilov\custompages\common\models\Page[] */
/* @var $tags \andrewdanilov\custompages\common\models\PageTag[] */
/* @var $pagination \yii\data\Pagination */

use andrewdanilov\custompages\frontend\assets\CustomPagesAsset;
use yii\helpers\Url;
use yii\widgets\LinkPager;

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

		<div class="all-tags">
			<?php foreach ($tags as $tag) { ?>
				<a href="<?= Url::to(['/custompages/default/page-tag', 'slug' => $tag->slug]) ?>" class="blog__tag"><?= $tag->name ?></a>
			<?php } ?>
		</div>

		<div class="tag-list">

			<?php foreach ($pages as $page) { ?>

				<div class="tag-list-item">

					<div class="list-item-image">
						<img src="<?= $page->image ?>" alt="">
					</div>
					<div class="list-item-content">
						<a class="list-item-title" href="<?= Url::to(['default/page', 'id' => $page->id]) ?>"><?= $page->title ?></a>
						<div>
							<?= $page->shortText ?>
						</div>
					</div>

				</div>

			<?php } ?>

		</div>

		<?= LinkPager::widget([
            'pagination' => $pagination,
        ]); ?>
	</div>
</div>
