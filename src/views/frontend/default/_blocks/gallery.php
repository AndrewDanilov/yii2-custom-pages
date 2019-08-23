<?php

/* @var $this \yii\web\View */
/* @var $album array */

?>
<div class="custom-pages-gallery">
	<?php foreach ($album as $photo) { ?>
		<div class="gallery-item">
			<a data-fancybox="gallery" href="<?= $photo ?>">
				<img src="<?= $photo ?>" alt="" />
			</a>
		</div>
	<?php } ?>
</div>