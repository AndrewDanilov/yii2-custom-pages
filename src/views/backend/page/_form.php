<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\elfinder\ElFinder;
use sadovojav\ckeditor\CKEditor;
use dosamigos\datepicker\DatePicker;
use andrewdanilov\InputImages\InputImages;
use andrewdanilov\custompages\models\Page;
use andrewdanilov\custompages\models\Category;
use andrewdanilov\gridtools\helpers\CKEditorHelper;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model Page */

\andrewdanilov\custompages\assets\CustomPagesBackendAsset::register($this);
?>

<div class="page-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->dropDownList(Category::getCategoriesList()) ?>

	<?= $form->field($model, 'image')->widget(InputImages::class) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hide_category_slug')->checkbox() ?>

	<?= $form->field($model, 'text')->widget(CKEditor::class, [
		'editorOptions' => ElFinder::ckeditorOptions('elfinder', CKEditorHelper::defaultOptions()),
	]) ?>

	<div class="custom-pages-albums">
		<label class="control-label">Albums</label>
		<div class="albums-list">
			<?php foreach ($model->albums as $album_id => $album) { ?>
				<div class="albums-item" data-id="<?= $album_id ?>">
					<?= $form->field($model, 'albums[' . $album_id . ']')->widget(InputImages::class, [
						'multiple' => true,
						'buttonName' => 'Add photo',
					])->label(false) ?>
					<div class="albums-item-controls">
						<a href="#" class="btn btn-danger albums-item-remove">Remove album</a>
						<a href="#" class="btn btn-default albums-item-copy-gallery" title="Get gallery shortcode"><span class="fa fa-clipboard"></span>&nbsp;&nbsp;[gallery <?= $album_id ?>]</a>
						<a href="#" class="btn btn-info albums-item-copy-slider" title="Get slider shortcode"><span class="fa fa-clipboard"></span>&nbsp;&nbsp;[slider <?= $album_id ?>]</a>
					</div>
				</div>
			<?php } ?>
		</div>
		<div class="albums-controls">
			<a href="#" class="btn btn-primary albums-controls-add">Add album</a>
		</div>
		<div class="albums-blank" style="display:none;">
			<div class="albums-item">
				<?= $form->field($model, 'albums[blankid]')->widget(InputImages::class, [
					'multiple' => true,
					'buttonName' => 'Add photo',
				])->label(false) ?>
				<div class="albums-item-controls">
					<a href="#" class="btn btn-danger albums-item-remove">Remove slider</a>
					<a href="#" class="btn btn-default albums-item-copy-gallery" title="Get gallery shortcode"><span class="fa fa-clipboard"></span>&nbsp;&nbsp;[gallery blankid]</a>
					<a href="#" class="btn btn-info albums-item-copy-slider" title="Get slider shortcode"><span class="fa fa-clipboard"></span>&nbsp;&nbsp;[slider blankid]</a>
				</div>
			</div>
		</div>
	</div>

	<?= $form->field($model, 'published_at')->widget(DatePicker::class, [
		'language' => 'ru',
		'template' => '{input}{addon}',
		'clientOptions' => [
			'autoclose' => true,
			'format' => 'dd.mm.yyyy',
			'clearBtn' => true,
			'todayBtn' => 'linked',
		],
		'clientEvents' => [
			'clearDate' => 'function (e) {$(e.target).find("input").change();}',
		],
	]) ?>

    <?= $form->field($model, 'is_main')->checkbox(['label' => 'Use as main page']) ?>

	<?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
