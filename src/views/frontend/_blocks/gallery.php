<?php

/* @var $this \yii\web\View */
/* @var $album array */

?>

<div class="custom-pages-gallery">
	<?php foreach ($album['photos'] as $photo) { ?>
		<div class="gallery-item">
			<a data-fancybox="gallery" href="<?= $photo['image'] ?>">
				<img src="<?= $photo['image'] ?>" alt="<?= $photo['alt'] ?>" />
			</a>
		</div>
	<?php } ?>
</div>