<?php

/* @var $this \yii\web\View */
/* @var $album array */

?>

<div class="custom-pages-slider swiper-container">
	<div class="swiper-wrapper">
		<?php foreach ($album['photos'] as $photo) { ?>
			<div class="swiper-slide">
				<a data-fancybox="slider" href="<?= $photo['image'] ?>">
					<img src="<?= $photo['image'] ?>" alt="<?= $photo['alt'] ?>" />
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