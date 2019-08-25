<?php

/* @var $this \yii\web\View */
/* @var $album array */
/* @var $params array */

use andrewdanilov\custompages\helpers\TextHelper;

?>
<div class="custom-pages-slider swiper-container">
	<div class="swiper-wrapper">
		<?php foreach ($album as $index => $photo) { ?>
			<?php $params_rendered = TextHelper::renderGalleryParamsValues($params, [
				'{index}' => $index,
				'{filename}' => pathinfo($photo, PATHINFO_FILENAME),
				'{basename}' => pathinfo($photo, PATHINFO_BASENAME),
				'{extension}' => pathinfo($photo, PATHINFO_EXTENSION),
			]) ?>
			<div class="swiper-slide">
				<a data-fancybox="slider" href="<?= $photo ?>">
					<img src="<?= $photo ?>" alt="<?= isset($params_rendered['alt']) ? $params_rendered['alt'] : '' ?>" />
				</a>
			</div>
		<?php } ?>
	</div>
	<!-- Add Pagination -->
	<div class="swiper-pagination"></div>
	<!-- Add Navigation -->
	<div class="swiper-button-prev"></div>
	<div class="swiper-button-next"></div>
</div>