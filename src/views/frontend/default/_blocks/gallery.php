<?php

/* @var $this \yii\web\View */
/* @var $album array */
/* @var $params array */

use andrewdanilov\custompages\helpers\TextHelper;

?>
<!--
<?php print_r($params); ?>
-->
<div class="custom-pages-gallery">
	<?php foreach ($album as $index => $photo) { ?>
		<?php $params_rendered = TextHelper::renderGalleryParamsValues($params, [
			'{index}' => $index,
			'{filename}' => pathinfo($photo, PATHINFO_FILENAME),
			'{basename}' => pathinfo($photo, PATHINFO_BASENAME),
			'{extension}' => pathinfo($photo, PATHINFO_EXTENSION),
		]) ?>
		<!--
		<?php print_r($params_rendered); ?>
		-->
		<div class="gallery-item">
			<a data-fancybox="gallery" href="<?= $photo ?>">
				<img src="<?= $photo ?>" alt="<?= isset($params_rendered['alt']) ? $params_rendered['alt'] : '' ?>" />
			</a>
		</div>
	<?php } ?>
</div>