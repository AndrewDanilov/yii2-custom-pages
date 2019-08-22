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

\andrewdanilov\custompages\CustomPagesBackendAsset::register($this);

?>

<div class="page-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->dropDownList(Category::getCategoriesList()) ?>

	<?= $form->field($model, 'image')->widget(InputImages::class) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'text')->widget(CKEditor::class, [
		'editorOptions' => ElFinder::ckeditorOptions('elfinder', CKEditorHelper::defaultOptions()),
	]) ?>

	<div class="custom-pages-sliders">
		<label class="control-label">Слайдеры</label>
		<div class="sliders-list">
			<?php foreach ($model->sliders as $slider_id => $slider) { ?>
				<div class="sliders-item" data-id="<?= $slider_id ?>">
					<?= $form->field($model, 'sliders[' . $slider_id . ']')->widget(InputImages::class, [
						'multiple' => true,
						'buttonName' => 'Добавить фото',
					])->label(false) ?>
					<a href="#" class="btn btn-danger sliders-item-remove">Удалить слайдер</a>
					<a href="#" class="btn btn-default sliders-item-copy" title="Скопировать в буфер обмена"><span class="fa fa-clipboard"></span>&nbsp;&nbsp;[<?= $slider_id ?>]</a>
				</div>
			<?php } ?>
		</div>
		<div class="sliders-controls">
			<a href="#" class="btn btn-primary sliders-controls-add">Добавить слайдер</a>
		</div>
		<div class="sliders-blank" style="display:none;">
			<div class="sliders-item">
				<?= $form->field($model, 'sliders[blankid]')->widget(InputImages::class, [
					'multiple' => true,
					'buttonName' => 'Добавить фото',
				])->label(false) ?>
				<a href="#" class="btn btn-danger sliders-item-remove">Удалить слайдер</a>
				<a href="#" class="btn btn-default sliders-item-copy" title="Скопировать в буфер обмена"><span class="fa fa-clipboard"></span>&nbsp;&nbsp;[blankid]</a>
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

	<?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
