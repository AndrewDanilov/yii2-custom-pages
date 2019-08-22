<?php

/* @var $this \yii\web\View */
/* @var $slider array */

?>
<div class="custom-pages-slider swiper-container">
	<div class="swiper-wrapper">
		<?php foreach ($slider as $slide) { ?>
			<div class="swiper-slide">
				<a data-fancybox="slider" href="<?= $slide ?>">
					<img src="<?= $slide ?>" alt="" />
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